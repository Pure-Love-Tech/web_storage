<?php

namespace App\Http\Controllers\Premium;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Plan;
use App\Models\PremiumPlan;
use App\Models\Subscription;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class PremiumController extends Controller
{
    public function index()
    {
        $plans = Plan::uploadActive()->orderBy('sort_id', 'asc')->get();
        $premiumPlans = Plan::premium()->first()->premium_plans;
        $paymentGateways = PaymentGateway::orderBy('sort_id', 'asc')->active()->get();
        return theme_view('premium.index', [
            'plans' => $plans,
            'premiumPlans' => $premiumPlans,
            'paymentGateways' => $paymentGateways,
        ]);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => ['required', 'integer', 'exists:premium_plans,id'],
            'payment_method' => ['sometimes', 'integer', 'exists:payment_gateways,id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $premiumPlan = PremiumPlan::findOrFail($request->plan_id);
        $paymentGateway = PaymentGateway::where('id', $request->payment_method)->active()->firstOrFail();
        if ($paymentGateway->isBalance()) {
            if ($user->balance() < $premiumPlan->price) {
                toastr()->error(translate('The Account balance is insufficient', 'premium'));
                return back();
            }
        }

        if ($paymentGateway->isManual() && !$paymentGateway->isBalance()) {
            $transactions = Transaction::where('user_id', $user->id)->pending()->get();
            if ($transactions->count() > 0) {
                toastr()->error(translate('You already have other pending transactions that use manual payment please wait until it gets reviewed', 'premium'));
                return back();
            }
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'price' => $premiumPlan->price,
            'interval' => $premiumPlan->interval,
            'payment_gateway_id' => $paymentGateway->id,
        ]);

        if ($transaction) {
            $paymentHandler = $paymentGateway->handler;
            $paymentData = $paymentHandler::process($transaction);
            $paymentData = json_decode($paymentData);
            if (isset($paymentData->error)) {
                toastr()->error($paymentData->msg);
                return back();
            }
            if (isset($paymentData->redirect_url)) {
                return redirect($paymentData->redirect_url);
            }
            return $this->view($paymentData->view, ['data' => $paymentData, 'trx' => $transaction]);
        }
    }

    public static function updateSubscriptionDetails($transaction)
    {
        $user = $transaction->user;
        $interval = $transaction->interval;
        if ($user->isSubscribed()) {
            $subscription = $user->subscription;
            if ($subscription->isExpired()) {
                $expiryAt = Carbon::now()->addDays($interval);
            } else {
                $expiryAt = Carbon::parse($subscription->expiry_at)->addDays($interval);
            }
            $subscription->user_id = $user->id;
            $subscription->expiry_at = $expiryAt;
            $subscription->expire_notification = false;
            $subscription->update();
        } else {
            $expiryAt = Carbon::now()->addDays($interval);
            $subscription = new Subscription();
            $subscription->user_id = $user->id;
            $subscription->expiry_at = $expiryAt;
            $subscription->save();
        }
    }

}
