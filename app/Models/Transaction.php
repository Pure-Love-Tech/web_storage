<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_UNPAID = 0;
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCELLED = 3;

    public function scopeUnpaid($query)
    {
        return $query->where('status', self::STATUS_UNPAID);
    }

    public function isUnpaid()
    {
        return $this->status == self::STATUS_UNPAID;
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function isCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    protected $fillable = [
        'user_id',
        'price',
        'interval',
        'payment_gateway_id',
        'payment_id',
        'payer_id',
        'payer_email',
        'status',
        'proof',
        'is_viewed',
    ];

    public function statusName()
    {
        if ($this->status == self::STATUS_UNPAID) {
            return translate('Unpaid', 'settings');
        } elseif ($this->status == self::STATUS_PENDING) {
            return translate('Pending', 'settings');
        } elseif ($this->status == self::STATUS_PAID) {
            return translate('Paid', 'settings');
        } elseif ($this->status == self::STATUS_CANCELLED) {
            return translate('Cancelled', 'settings');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }
}