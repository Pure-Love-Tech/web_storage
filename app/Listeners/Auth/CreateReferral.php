<?php

namespace App\Listeners\Auth;

use App\Events\Registered;
use App\Models\Referral;
use Illuminate\Support\Facades\Cookie;

class CreateReferral
{
    public function handle(Registered $event)
    {
        $user = $event->user;
        $referrer = $event->referrer;
        if ($referrer) {
            $referral = new Referral();
            $referral->referring_user_id = $referrer->id;
            $referral->referred_user_id = $user->id;
            $referral->save();
            Cookie::queue(Cookie::forget('_ref'));
        }
    }

}
