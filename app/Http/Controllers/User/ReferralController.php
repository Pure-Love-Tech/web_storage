<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Referral;

class ReferralController extends Controller
{
    public function index()
    {
        $referrals = Referral::where('referring_user_id', auth()->user()->id)->orderbyDesc('id')->paginate(20);
        return theme_view('user.referrals', ['referrals' => $referrals]);
    }
}
