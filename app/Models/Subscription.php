<?php

namespace App\Models;

use App\Notifications\Subscription\SubscriptionDeletedNotification;
use App\Notifications\Subscription\SubscriptionExpireNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public function scopeExpired($query)
    {
        $query->where('expiry_at', '<', Carbon::now());
    }

    public function scopeNotExpired($query)
    {
        $query->where('expiry_at', '>', Carbon::now());
    }

    public function isExpired()
    {
        return $this->expiry_at < Carbon::now();
    }

    protected $fillable = [
        'user_id',
        'expiry_at',
        'expire_notification',
        'is_viewed',
    ];

    protected $casts = [
        'expiry_at' => 'datetime',
    ];

    public function sendSubscriptionExpireNotification()
    {
        if (mailTemplate('subscription_expire_notification')->status) {
            $this->user->notify(new SubscriptionExpireNotification($this));
        }
    }

    public function sendSubscriptionDeletedNotification()
    {
        if (mailTemplate('subscription_deleted_notification')->status) {
            $this->user->notify(new SubscriptionDeletedNotification($this));
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
