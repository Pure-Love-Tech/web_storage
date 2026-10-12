<?php

namespace App\Http\Controllers\Premium\Payments\Balance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Premium\PremiumController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        $data['view'] = "premium.gateways.balance";
        return json_encode($data);
    }

    public function execute(Request $request)
    {
        try {
            $trx = Transaction::where([['id', $request->trx], ['user_id', auth()->user()->id]])->unpaid()->firstOrFail();
            $user = $trx->user;
            if ($user->balance() < $trx->price) {
                toastr()->error(translate('The Account balance is insufficient', 'premium'));
                return back();
            }
            $trx->payer_email = $user->email;
            $trx->status = Transaction::STATUS_PAID;
            $trx->update();
            if ($user->downloads_earnings >= $trx->price) {
                $user->decrement('downloads_earnings', $trx->price);
            } elseif ($user->referrals_earnings >= $trx->price) {
                $user->decrement('referrals_earnings', $trx->price);
            } else {
                $payByReferralsEarnings = ($trx->price - $user->downloads_earnings);
                $payByDownloadsEarnings = ($trx->price - $payByReferralsEarnings);
                $user->decrement('downloads_earnings', $payByDownloadsEarnings);
                $user->decrement('referrals_earnings', $payByReferralsEarnings);
            }
            PremiumController::updateSubscriptionDetails($trx);
            toastr()->success(translate('Payment made successfully', 'premium'));
            return redirect()->route('user.settings.subscription');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->route('user.settings.subscription');
        }
    }
}
