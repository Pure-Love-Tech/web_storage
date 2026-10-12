<?php

namespace App\Http\Controllers\Premium\Payments\Coingate;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        try {
            $client = new \CoinGate\Client(paymentGateway('coingate')->credentials->auth_token, true);
            $params = [
                'title' => translate('Payment For Subscription', 'premium'),
                'order_id' => $trx->id,
                'price_amount' => round($trx->price, 2),
                'price_currency' => settings('currency')->code,
                'receive_currency' => settings('currency')->code,
                'callback_url' => route('premium.payment.coingate'),
                'cancel_url' => route('premium.index'),
                'success_url' => route('user.settings.subscription'),
            ];
            $order = $client->order->create($params);
            if ($order) {
                $data['redirect_url'] = $order->payment_url;
            } else {
                $data['error'] = true;
                $data['msg'] = translate('An error occurred while calling the API', 'premium');
            }
        } catch (Exception $e) {
            $data['error'] = true;
            $data['msg'] = $e->getMessage();
        }
        return json_encode($data);
    }

    public function execute(Request $request)
    {
        try {
            $trx = Transaction::where('id', $request->order_id)->unpaid()->firstOrFail();
            if ($trx && $request->status == "paid" && $request->price_amount == $trx->price) {
                $trx->payment_id = $request->id;
                $trx->status = Transaction::STATUS_PAID;
                $trx->update();
                PremiumController::updateSubscriptionDetails($trx);
            }
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }
}
