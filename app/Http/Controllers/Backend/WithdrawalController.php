<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Validator;

class WithdrawalController extends Controller
{
    public function index()
    {
        updateIsViewed(Withdrawal::class);

        $users = User::all();
        $withdrawalMethods = WithdrawalMethod::orderBy('sort_id', 'asc')->get();

        $withdrawals = Withdrawal::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $withdrawals->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('user_id', 'like', $searchTerm)
                    ->orWhere('account', 'like', $searchTerm)
                    ->orWhere('method', 'like', $searchTerm);
            });
        }
        if (request()->filled('user')) {
            $withdrawals->where('user_id', request('user'));
        }
        if (request()->filled('status')) {
            $withdrawals->where('status', request('status'));
        }
        if (request()->filled('withdrawal_method')) {
            $withdrawals->where('method', request('withdrawal_method'));
        }

        $filteredWithdrawals = $withdrawals->get();

        $counters['pending'] = $filteredWithdrawals->where('status', Withdrawal::STATUS_PENDING)->count();
        $counters['returned'] = $filteredWithdrawals->where('status', Withdrawal::STATUS_RETURNED)->count();
        $counters['approved'] = $filteredWithdrawals->where('status', Withdrawal::STATUS_APPROVED)->count();
        $counters['completed'] = $filteredWithdrawals->where('status', Withdrawal::STATUS_COMPLETED)->count();
        $counters['cancelled'] = $filteredWithdrawals->where('status', Withdrawal::STATUS_CANCELLED)->count();

        $counters['pending_withdrawal_amount'] = $filteredWithdrawals->where('status', Withdrawal::STATUS_PENDING)->sum('total');
        $counters['total_withdrawn_amount'] = $filteredWithdrawals->whereIn('status', [Withdrawal::STATUS_APPROVED, Withdrawal::STATUS_COMPLETED])->sum('total');

        $withdrawals = $withdrawals->orderByDesc('id')->paginate(50);
        $withdrawals->appends(request()->only(['search', 'user', 'status', 'withdrawal_method']));

        return view('backend.withdrawals.index', [
            'counters' => $counters,
            'users' => $users,
            'withdrawalMethods' => $withdrawalMethods,
            'withdrawals' => $withdrawals,
        ]);
    }

    public function edit(Withdrawal $withdrawal)
    {
        updateIsViewed(Withdrawal::class);
        return view('backend.withdrawals.edit', ['withdrawal' => $withdrawal]);
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        abort_if(in_array($withdrawal->status, [2, 5]), 401);
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'integer', 'min:1', 'max:5'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->status == $withdrawal->status) {
            toastr()->info(admin_trans('The status has not changed'));
            return back();
        }
        if ($request->has('user_notify')) {
            if (!settings('smtp')->status) {
                toastr()->error(admin_trans('SMTP is not enabled'));
                return back();
            }
            if (!mailTemplate('user_withdrawal_notification')->status) {
                toastr()->error(admin_trans('Email template is disabled from mail templates'));
                return back();
            }
        }
        $updateWithdrawal = $withdrawal->update(['status' => $request->status]);
        if ($updateWithdrawal) {
            if ($request->status == 2) {
                $withdrawal->user->increment('downloads_earnings', $withdrawal->downloads_earnings);
                $withdrawal->user->increment('referrals_earnings', $withdrawal->referrals_earnings);
            }
            if ($request->has('user_notify')) {
                $withdrawal->user->sendWithdrawalNotification($withdrawal);
            }
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }

    public function destroy(Withdrawal $withdrawal)
    {
        deleteAdminNotification(route('admin.withdrawals.edit', $withdrawal->id));
        $withdrawal->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }
}
