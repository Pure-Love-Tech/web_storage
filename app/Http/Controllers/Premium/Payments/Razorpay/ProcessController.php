<?php

namespace App\Http\Controllers\Premium\Payments\Razorpay;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        try {
            $gatewayCredentials = paymentGateway('razorpay')->credentials;
            $price = str_replace('.', '', ($trx->price * 100));
            $api = new Api($gatewayCredentials->key_id, $gatewayCredentials->key_secret);
            $order = $api->order->create([
                'receipt' => $trx->id,
                'amount' => $price,
                'currency' => settings('currency')->code,
                'payment_capture' => '0',
            ]);
            $details = [
                'key' => $gatewayCredentials->key_id,
                'amount' => $price,
                'currency' => settings('currency')->code,
                'order_id' => $order['id'],
                'buttontext' => translate('Pay Now', 'premium'),
                'name' => settings('general')->site_name,
                'description' => translate('Payment For Subscription', 'premium'),
                'image' => asset(themeSettings('general')->logo_dark),
                'prefill.name' => $trx->user->name,
                'prefill.email' => $trx->user->email,
                'theme.color' => themeSettings('colors')->primary_color,
            ];
            $data['trx'] = $trx;
            $data['details'] = $details;
            $data['view'] = "premium.gateways.razorpay";
            $trx->payment_id = $order['id'];
            $trx->update();
        } catch (Exception $e) {
            $data['error'] = true;
            $data['msg'] = $e->getMessage();
        }
        return json_encode($data);

    }

    public function execute(Request $request)
    {
        $trxId = unhashid($request->trx_id);
        $orderId = $request->razorpay_order_id;
        $paymentId = $request->razorpay_payment_id;
        try {
            $trx = Transaction::where([['user_id', auth()->user()->id], ['id', $trxId], ['payment_id', $orderId]])->unpaid()->firstOrFail();
            $signature = hash_hmac('sha256', $orderId . "|" . $paymentId, paymentGateway('razorpay')->credentials->key_secret);
            if ($signature == $request->razorpay_signature) {
                $trx->payment_id = $paymentId;
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
