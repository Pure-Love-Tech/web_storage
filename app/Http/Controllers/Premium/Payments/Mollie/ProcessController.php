<?php

namespace App\Http\Controllers\Premium\Payments\Mollie;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        try {
            config(['mollie.key' => trim(paymentGateway('mollie')->credentials->api_key)]);
            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => settings('currency')->code,
                    "value" => formatPrice($trx->price),
                ],
                "description" => translate('Payment For Subscription', 'premium'),
                "redirectUrl" => route('premium.payment.mollie', 'trx_id=' . hashid($trx->id)),
                "metadata" => [
                    "trx_id" => $trx->id,
                ],
            ]);
            $payment = Mollie::api()->payments()->get($payment->id);
            $trx->payment_id = $payment->id;
            $trx->update();
            $data['redirect_url'] = $payment->getCheckoutUrl();
        } catch (Exception $e) {
            $data['error'] = true;
            $data['msg'] = $e->getMessage();
        }
        return json_encode($data);
    }

    public function execute(Request $request)
    {
        $trxId = unhashid($request->trx_id);
        try {
            $trx = Transaction::where([['user_id', auth()->user()->id], ['id', $trxId], ['payment_id', '!=', null]])->unpaid()->firstOrFail();
            config(['mollie.key' => trim(paymentGateway('mollie')->credentials->api_key)]);
            $payment = Mollie::api()->payments()->get($trx->payment_id);
            if ($payment->metadata->trx_id != $trx->id) {
                toastr()->error(translate('Payment failed', 'premium'));
                return redirect()->route('user.settings.subscription');
            }
            if ($payment->status == "paid") {
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
