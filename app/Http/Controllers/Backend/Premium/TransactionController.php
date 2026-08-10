<?php

namespace App\Http\Controllers\Backend\Premium;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\PaymentGateway;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class TransactionController extends Controller
{
    public function index()
    {
        updateIsViewed(Transaction::class);
        $users = User::all();
        $plans = Plan::all();
        $paymentGateways = PaymentGateway::orderBy('sort_id', 'asc')->get();
        $transactions = Transaction::query();
        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $transactions->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('payment_id', 'like', $searchTerm)
                    ->orWhere('payer_id', 'like', $searchTerm)
                    ->orWhere('payer_email', 'like', $searchTerm)
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm)
                            ->orWhere('username', 'like', $searchTerm)
                            ->orWhere('email', 'like', $searchTerm)
                            ->orWhere('mobile', 'like', $searchTerm);
                    })
                    ->orWhereHas('paymentGateway', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    });
            });
        }
        if (request()->filled('user')) {
            $transactions->where('user_id', request('user'));
        }
        if (request()->filled('status')) {
            $transactions->where('status', request('status'));
        }
        if (request()->filled('payment_method')) {
            $transactions->where('payment_gateway_id', request('payment_method'));
        }

        $filteredTransactions = $transactions->get();
        $counters['unpaid']['number'] = $filteredTransactions->where('status', Transaction::STATUS_UNPAID)->count();
        $counters['unpaid']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_UNPAID)->sum('price');
        $counters['pending']['number'] = $filteredTransactions->where('status', Transaction::STATUS_PENDING)->count();
        $counters['pending']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_PENDING)->sum('price');
        $counters['paid']['number'] = $filteredTransactions->where('status', Transaction::STATUS_PAID)->count();
        $counters['paid']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_PAID)->sum('price');
        $counters['cancelled']['number'] = $filteredTransactions->where('status', Transaction::STATUS_CANCELLED)->count();
        $counters['cancelled']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_CANCELLED)->sum('price');

        $transactions = $transactions->orderByDesc('id')->paginate(50);
        $transactions->appends(request()->only(['search', 'user', 'plan', 'type', 'status', 'payment_method']));

        return view('backend.premium.transactions.index', [
            'counters' => $counters,
            'transactions' => $transactions,
            'users' => $users,
            'plans' => $plans,
            'paymentGateways' => $paymentGateways,
        ]);
    }

    public function show(Transaction $transaction)
    {
        abort_if(!$transaction->proof, 404);
        try {
            $disk = Storage::disk('local');
            $file = $disk->get($transaction->proof);
            $response = \Response::make($file, 200);
            $response->header("Content-Type", $disk->mimeType($transaction->proof));
            return $response;
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function edit(Transaction $transaction)
    {
        updateIsViewed(Transaction::class);
        return view('backend.premium.transactions.edit', ['trx' => $transaction]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_if(!$transaction->isPending(), 401);
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'integer', 'min:2', 'max:3'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $transaction->status = $request->status;
        $transaction->update();
        if ($transaction->status == Transaction::STATUS_PAID) {
            PremiumController::updateSubscriptionDetails($transaction);
        }
        $transaction->user->sendTransactionNotification($transaction);
        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->proof) {
            storageRemove($transaction->proof, 'local');
        }
        deleteAdminNotification(route('admin.premium.transactions.edit', $transaction->id));
        $transaction->delete();
        toastr()->success(admin_trans('Deleted successfully'));
        return back();
    }
}
