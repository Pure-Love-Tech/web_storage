<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return theme_view('user.settings.index', ['user' => $this->user()]);
    }

    public function detailsUpdate(Request $request)
    {
        $indisposable = settings('actions')->disposable_emails_status ? ['indisposable'] : [];
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'max:50', 'block_patterns'],
            'lastname' => ['required', 'string', 'max:50', 'block_patterns'],
            'email' => ['required', 'string', 'email', 'max:100', 'block_patterns', 'unique:users,email,' . $this->user()->id] + $indisposable,
            'mobile' => ['nullable', 'numeric', 'block_patterns', 'unique:users,mobile,' . $this->user()->id],
            'address_1' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'address_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['nullable', 'string', 'max:150', 'block_patterns'],
            'state' => ['nullable', 'string', 'max:150', 'block_patterns'],
            'zip' => ['nullable', 'string', 'max:100', 'block_patterns'],
            'country' => ['nullable', 'numeric', 'exists:countries,id'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $verify = (settings('actions')->email_verification_status && $this->user()->email != $request->email) ? 1 : 0;
        $country = Country::find($request->country);
        $address = [
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $country->name ?? null,
        ];
        if ($request->has('avatar')) {
            if ($this->user()->avatar == 'images/avatars/default.png') {
                $avatar = imageUpload($request->file('avatar'), 'images/avatars/users/', '110x110');
            } else {
                $avatar = imageUpload($request->file('avatar'), 'images/avatars/users/', '110x110', null, $this->user()->avatar);
            }
        } else {
            $avatar = $this->user()->avatar;
        }
        $update = $this->user()->update([
            'name' => $request->firstname . ' ' . $request->lastname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $address,
            'avatar' => $avatar,
        ]);
        if ($update) {
            if ($verify) {
                $this->user()->forceFill(['email_verified_at' => null])->save();
                $this->user()->sendEmailVerificationNotification();
            }
            toastr()->success(translate('Account details has been updated successfully', 'settings'));
            return back();
        }
    }

    public function password()
    {
        return theme_view('user.settings.password');
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:8', 'confirmed'],
            'new-password_confirmation' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if (!(Hash::check($request->get('current-password'), $this->user()->password))) {
            toastr()->error(translate('Your current password does not matches with the password you provided', 'passwords'));
            return back();
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            toastr()->error(translate('New Password cannot be same as your current password. Please choose a different password', 'passwords'));
            return back();
        }
        $update = $this->user()->update([
            'password' => bcrypt($request->get('new-password')),
        ]);
        if ($update) {
            toastr()->success(translate('Account password has been changed successfully', 'settings'));
            return back();
        }
    }

    public function towFactor()
    {
        $QR_Image = null;
        if (!$this->user()->google2fa_status) {
            $google2fa = app('pragmarx.google2fa');
            $secretKey = encrypt($google2fa->generateSecretKey());
            $this->user()->update(['google2fa_secret' => $secretKey]);
            $QR_Image = $google2fa->getQRCodeInline(settings('general')->site_name, $this->user()->email, $this->user()->google2fa_secret);
        }
        return theme_view('user.settings.2fa', ['user' => $this->user(), 'QR_Image' => $QR_Image]);
    }

    public function towFactorEnable(Request $request)
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
        $valid = $google2fa->verifyKey($this->user()->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(translate('Invalid OTP code', 'settings'));
            return back();
        }
        $update = $this->user()->update(['google2fa_status' => true]);
        if ($update) {
            session()->put('user_2fa', encrypt($this->user()->id));
            toastr()->success(translate('2FA Authentication has been enabled successfully', 'settings'));
            return back();
        }

    }

    public function towFactorDisable(Request $request)
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
        $valid = $google2fa->verifyKey($this->user()->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(translate('Invalid OTP code', 'settings'));
            return back();
        }
        $update = $this->user()->update(['google2fa_status' => false]);
        if ($update) {
            if ($request->session()->has('user_2fa')) {
                session()->forget('user_2fa');
            }
            toastr()->success(translate('2FA Authentication has been disabled successfully', 'settings'));
            return back();
        }
    }

    public function withdrawal()
    {
        $withdrawalMethods = WithdrawalMethod::orderBy('sort_id', 'asc')->active()->get();
        return theme_view('user.settings.withdrawal', ['user' => $this->user(), 'withdrawalMethods' => $withdrawalMethods]);
    }

    public function withdrawalUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'withdrawal_method' => ['nullable', 'integer', 'exists:withdrawal_methods,id'],
            'withdrawal_account' => ['nullable', 'string', 'max:500', 'block_patterns'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if (!is_null($request->withdrawal_method) && is_null($request->withdrawal_account)) {
            toastr()->error(translate('Withdrawal Account cannot be empty', 'settings'));
            return back();
        }
        if (is_null($request->withdrawal_method)) {
            $request->withdrawal_account = null;
        }
        $update = $this->user()->update([
            'withdrawal_method_id' => $request->withdrawal_method,
            'withdrawal_account' => $request->withdrawal_account,
        ]);
        if ($update) {
            toastr()->success(translate('Withdrawal details has been updated successfully', 'settings'));
            return back();
        }
    }

    public function subscription()
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->whereIn('status', [1, 2, 3])->orderbyDesc('id')->paginate(20);
        return theme_view('user.settings.subscription', ['user' => $this->user(), 'transactions' => $transactions]);
    }

    public function cancelSubscription()
    {
        $user = auth()->user();

        abort_if(!$user->isSubscribed(), 403);

        $plan = Plan::forUsers()->first();

        if ($plan->getStorageSpace() && $plan->getStorageSpace() < subscription()->storage->used->number) {
            toastr()->error(translate('Your used space is more than the space available for the users plan', 'settings'));
            return back();
        }

        $user->subscription->delete();
        toastr()->success(translate('Your subscription has been cancelled successfully', 'settings'));
        return back();
    }

    protected function user()
    {
        return auth()->user();
    }
}
