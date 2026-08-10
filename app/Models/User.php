<?php

namespace App\Models;

use App\Models\UserLog;
use App\Notifications\User\UserResetPasswordNotification;
use App\Notifications\User\UserTransactionNotification;
use App\Notifications\User\UserWithdrawalNotification;
use App\Notifications\User\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public function isSubscribed()
    {
        return $this->subscription;
    }

    public function balance()
    {
        return ($this->downloads_earnings + $this->referrals_earnings);
    }

    public function hasWithdrawalAccount()
    {
        return $this->withdrawal_method_id && $this->withdrawal_account;
    }

    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'username',
        'email',
        'mobile',
        'downloads_earnings',
        'referrals_earnings',
        'address',
        'avatar',
        'withdrawal_method_id',
        'withdrawal_account',
        'password',
        'facebook_id',
        'google_id',
        'google2fa_status',
        'google2fa_secret',
        'is_viewed',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'address' => 'object',
        'email_verified_at' => 'datetime',
    ];

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        if (settings('actions')->email_verification_status) {
            $this->notify(new VerifyEmailNotification());
        }
    }

    public function sendTransactionNotification($transaction)
    {
        if (settings('smtp')->status && mailTemplate('user_transaction_notification')->status) {
            $this->notify(new UserTransactionNotification($transaction));
        }
    }

    public function sendWithdrawalNotification($withdrawal)
    {
        if (settings('smtp')->status && mailTemplate('user_withdrawal_notification')->status) {
            $this->notify(new UserWithdrawalNotification($withdrawal));
        }
    }

    public function setLog()
    {
        $loginLog = UserLog::where([['user_id', $this->id], ['ip', ipInfo()->ip]])->first();
        $location = ipInfo()->location->city . ', ' . ipInfo()->location->country;
        if ($loginLog != null) {
            $loginLog->country = ipInfo()->location->country;
            $loginLog->country_code = ipInfo()->location->country_code;
            $loginLog->timezone = ipInfo()->location->timezone;
            $loginLog->location = $location;
            $loginLog->latitude = ipInfo()->location->latitude;
            $loginLog->longitude = ipInfo()->location->longitude;
            $loginLog->browser = ipInfo()->system->browser;
            $loginLog->os = ipInfo()->system->os;
            $loginLog->update();
        } else {
            $newLoginLog = new UserLog();
            $newLoginLog->user_id = $this->id;
            $newLoginLog->ip = ipInfo()->ip;
            $newLoginLog->country = ipInfo()->location->country;
            $newLoginLog->country_code = ipInfo()->location->country_code;
            $newLoginLog->timezone = ipInfo()->location->timezone;
            $newLoginLog->location = $location;
            $newLoginLog->latitude = ipInfo()->location->latitude;
            $newLoginLog->longitude = ipInfo()->location->longitude;
            $newLoginLog->browser = ipInfo()->system->browser;
            $newLoginLog->os = ipInfo()->system->os;
            $newLoginLog->save();
        }
    }

    public function usernameMasked()
    {
        $username = strlen($this->username);
        return substr($this->username, 0, 4) . str_repeat('*', $username - 4);
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referring_user_id');
    }

    public function referrer()
    {
        return $this->hasOne(Referral::class, 'referred_user_id');
    }

    public function withdrawal_method()
    {
        return $this->belongsTo(WithdrawalMethod::class);
    }

    public function file_entries()
    {
        return $this->hasMany(FileEntry::class);
    }
}
