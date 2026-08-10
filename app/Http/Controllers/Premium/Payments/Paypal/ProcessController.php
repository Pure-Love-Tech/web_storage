<?php

namespace App\Http\Controllers\Premium\Payments\Paypal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\Payments\Paypal\Sdk\Core\PayPalHttpClient;
use App\Http\Controllers\Premium\Payments\Paypal\Sdk\Core\ProductionEnvironment;
use App\Http\Controllers\Premium\Payments\Paypal\Sdk\Orders\OrdersCaptureRequest;
use App\Http\Controllers\Premium\Payments\Paypal\Sdk\Orders\OrdersCreateRequest;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        $gatewayCredentials = paymentGateway('paypal')->credentials;
        $environment = new ProductionEnvironment($gatewayCredentials->client_id, $gatewayCredentials->client_secret);
        $client = new PayPalHttpClient($environment);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $trx->id,
                "description" => translate('Payment For Subscription', 'premium'),
                "amount" => [
                    "value" => formatPrice($trx->price),
                    "currency_code" => settings('currency')->code,
                ],
            ]],
            "application_context" => [
                "cancel_url" => route('user.settings.subscription'),
                "return_url" => route('premium.payment.paypal'),
            ],
        ];
        try {
            $response = $client->execute($request);
            $trx->payment_id = $response->result->id;
            $trx->update();
            $data['redirect'] = true;
            $data['redirect_url'] = $response->result->links[1]->href;
        } catch (Exception $e) {
            $data['error'] = true;
            $data['msg'] = $e->getMessage();
        }
        return json_encode($data);
    }

    public function execute(Request $req)
    {
        try {
            $trx = Transaction::where([['user_id', auth()->user()->id], ['payment_id', $req->token]])->unpaid()->firstOrFail();
            $request = new OrdersCaptureRequest($trx->payment_id);
            $request->prefer('return=representation');
            $gatewayCredentials = paymentGateway('paypal')->credentials;
            $environment = new ProductionEnvironment($gatewayCredentials->client_id, $gatewayCredentials->client_secret);
            $client = new PayPalHttpClient($environment);
            $response = $client->execute($request);
            if (@$response->result->status == 'COMPLETED') {
                $trx->payer_id = $response->result->payer->payer_id;
                $trx->payer_email = $response->result->payer->email_address;
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
