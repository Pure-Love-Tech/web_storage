<?php

namespace App\Http\Controllers\Premium\Payments\Paystack;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        $data['key'] = paymentGateway('paystack')->credentials->public_key;
        $data['email'] = $trx->user->email;
        $data['amount'] = ($trx->price * 100);
        $data['currency'] = settings('currency')->code;
        $data['ref'] = $trx->id;
        $data['view'] = 'premium.gateways.paystack';
        return json_encode($data);
    }

    public function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => ['required'],
            'paystack-trxref' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $reference = $request->reference;
        $trx = Transaction::where([['user_id', auth()->user()->id], ['id', $reference]])->unpaid()->firstOrFail();
        try {
            $response = self::verifyReference($reference);
            $result = json_decode($response, true);
            if ($result && $result['data']['status'] == "success") {
                $customer = $result['data']['customer'];
                $trx->payment_id = $result['data']['id'];
                $trx->payer_id = $customer['id'];
                $trx->payer_email = $customer['email'];
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

    private static function verifyReference($reference)
    {
        $client = new Client();
        $paystackSecretKey = paymentGateway('paystack')->credentials->secret_key;
        $response = $client->request('GET', 'https://api.paystack.co/transaction/verify/' . $reference, [
            'headers' => [
                'Authorization' => 'Bearer ' . $paystackSecretKey,
            ],
        ]);
        return $response->getBody();
    }
}
