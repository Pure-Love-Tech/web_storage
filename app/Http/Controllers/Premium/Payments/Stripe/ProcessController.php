<?php

namespace App\Http\Controllers\Premium\Payments\Stripe;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        $paymentDeatails = [
            'customer_creation' => 'always',
            'customer_email' => $trx->user->email,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'unit_amount' => str_replace('.', '', ($trx->price * 100)),
                    'currency' => settings('currency')->code,
                    'product_data' => [
                        'name' => settings('general')->site_name,
                        'description' => translate('Payment For Subscription', 'premium'),
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'cancel_url' => route('user.settings.subscription'),
            'success_url' => route('premium.payment.stripe') . '?session_id={CHECKOUT_SESSION_ID}',
        ];
        try {
            Stripe::setApiKey(paymentGateway('stripe')->credentials->secret_key);
            $session = Session::create($paymentDeatails);
            if ($session) {
                $trx->payment_id = $session->id;
                $trx->update();
                $data['redirect_url'] = $session->url;
            }
        } catch (Exception $e) {
            $data['error'] = true;
            $data['msg'] = $e->getMessage();
        }
        return json_encode($data);
    }

    public function execute(Request $request)
    {
        $sessionId = $request->session_id;
        try {
            Stripe::setApiKey(paymentGateway('stripe')->credentials->secret_key);
            $trx = Transaction::where([['user_id', auth()->user()->id], ['payment_id', $sessionId]])->unpaid()->firstOrFail();
            $session = Session::retrieve($sessionId);
            if ($session->payment_status == "paid" && $session->status == "complete") {
                $customer = Customer::retrieve($session->customer);
                $trx->payer_id = $customer->id;
                $trx->payer_email = $customer->email;
                $trx->status = Transaction::STATUS_PAID;
                $trx->update();
                PremiumController::updateSubscriptionDetails($trx);
                toastr()->success(translate('Payment made successfully', 'premium'));
                return redirect()->route('user.settings.subscription');
            } else {
                toastr()->error(translate('Payment failed', 'premium'));
                return redirect()->route('user.settings.subscription');
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->route('user.settings.subscription');
        }
    }
}
