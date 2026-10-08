<?php

namespace App\Http\Controllers\User;

use App\Events\WithdrawalCreated;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $counters['pending_withdrawals'] = Withdrawal::where('user_id', auth()->user()->id)->pending()->sum('total');
        $counters['total_withdrawals'] = Withdrawal::where('user_id', auth()->user()->id)
            ->whereIn('status', [Withdrawal::STATUS_APPROVED, Withdrawal::STATUS_COMPLETED])
            ->sum('total');
        $withdrawals = Withdrawal::where('user_id', auth()->user()->id)->orderbyDesc('id')->paginate(20);
        return theme_view('user.withdrawals', ['counters' => $counters, 'withdrawals' => $withdrawals]);
    }

    public function withdraw(Request $request)
    {
        $user = auth()->user();
        if ($user->balance() < 0.10 || $user->balance() < $user->withdrawal_method->minimum) {
            toastr()->error(translate('Your balance is less than the minimum withdrawal limit', 'withdrawals'));
            return back();
        }
        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'downloads_earnings' => $user->downloads_earnings,
            'referrals_earnings' => $user->referrals_earnings,
            'total' => ($user->downloads_earnings + $user->referrals_earnings),
            'method' => $user->withdrawal_method->name,
            'account' => $user->withdrawal_account,
        ]);
        if ($withdrawal) {
            $user->downloads_earnings = 0;
            $user->referrals_earnings = 0;
            $user->update();
            event(new WithdrawalCreated($withdrawal));
            toastr()->success(translate('Your withdrawal request has been sent successfully', 'withdrawals'));
            return back();
        }
    }
}
