<?php

namespace App\Models\Backend;

use App\Notifications\Admin\AdminResetPasswordNotification;
use App\Notifications\Admin\AdminTransactionNotification;
use App\Notifications\Admin\AdminWithdrawalNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'admins';

    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'avatar',
        'password',
        'google2fa_status',
        'google2fa_secret',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function sendTransactionNotification($transaction)
    {
        if (settings('smtp')->status && mailTemplate('admin_transaction_notification')->status) {
            $this->notify(new AdminTransactionNotification($transaction));
        }
    }

    public function sendWithdrawalNotification($withdrawal)
    {
        if (settings('smtp')->status && mailTemplate('admin_withdrawal_notification')->status) {
            $this->notify(new AdminWithdrawalNotification($withdrawal));
        }
    }

    public function blogArticles()
    {
        return $this->hasMany(Blog_Article::class, 'id');
    }
}
