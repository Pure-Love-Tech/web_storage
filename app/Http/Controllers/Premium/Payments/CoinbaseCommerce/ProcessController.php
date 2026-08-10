<?php

namespace App\Http\Controllers\Premium\Payments\CoinbaseCommerce;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProcessController extends Controller
{

    public static function process($trx)
    {
        $array = [
            'name' => $trx->user->name,
            'description' => translate('Payment For Subscription', 'premium'),
            'pricing_type' => "fixed_price",
            'local_price' => [
                'amount' => $trx->price,
                'currency' => settings('currency')->code,
            ],
            'metadata' => [
                'trx_id' => $trx->id,
            ],
            'redirect_url' => route('user.settings.subscription'),
            'cancel_url' => route('premium.index'),
        ];
        try {
            $response = self::callApi($array);
            $result = json_decode($response);
            if (@$result->error == '') {
                $trx->payment_id = $result->data->id;
                $trx->update();
                $data['redirect_url'] = $result->data->hosted_url;
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
            $data = file_get_contents("php://input");
            $response = json_decode($data);
            $trx = Transaction::where('id', $response->event->data->metadata->trx_id)->unpaid()->firstOrFail();
            $coinbaseWebhookSharedSecret = paymentGateway('coinbase_commerce')->credentials->webhook_shared_secret;
            $headers = apache_request_headers();
            $headers = json_decode(json_encode($headers), true);
            $webhookSignature = $headers['X-Cc-Webhook-Signature'];
            $signature = hash_hmac('sha256', $data, $coinbaseWebhookSharedSecret);
            if ($webhookSignature == $signature) {
                if ($response->event->type == 'charge:confirmed') {
                    $trx->status = Transaction::STATUS_PAID;
                    $trx->update();
                    PremiumController::updateSubscriptionDetails($trx);
                }
            }
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }

    private static function callApi($array)
    {
        $client = new Client();
        $coinbaseApiKey = paymentGateway('coinbase_commerce')->credentials->api_key;
        $headers = [
            'Content-Type' => 'application/json',
            'X-CC-Api-Key' => $coinbaseApiKey,
            'X-CC-Version' => '2018-03-22',
        ];
        $response = $client->post('https://api.commerce.coinbase.com/charges', [
            'headers' => $headers,
            'json' => $array,
        ]);
        return $response->getBody()->getContents();
    }
}