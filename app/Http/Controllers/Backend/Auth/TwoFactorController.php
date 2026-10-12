<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TwoFactorController extends Controller
{
    public function show2FaVerifyForm()
    {
        if (!auth()->guard('admin')->user()->google2fa_status || session()->has('admin_2fa') &&
            session('admin_2fa') == encrypt(auth()->guard('admin')->user()->id)) {
            return redirect()->route('admin.dashboard');
        }
        return view('backend.auth.2fa');
    }

    public function verify2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey(auth()->guard('admin')->user()->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(admin_trans('Invalid OTP code'));
            return back();
        }

        session()->put('admin_2fa', encrypt(auth()->guard('admin')->user()->id));
        return redirect()->route('admin.dashboard');
    }
}
