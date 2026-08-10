<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    const STATUS_PENDING = 1;
    const STATUS_RETURNED = 2;
    const STATUS_APPROVED = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_CANCELLED = 5;

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopeReturned($query)
    {
        $query->where('status', self::STATUS_RETURNED);
    }

    public function isReturned()
    {
        return $this->status == self::STATUS_RETURNED;
    }

    public function scopeApproved($query)
    {
        $query->where('status', self::STATUS_APPROVED);
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function scopeCompleted($query)
    {
        $query->where('status', self::STATUS_COMPLETED);
    }

    public function isCompleted()
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    public function scopeCancelled($query)
    {
        $query->where('status', self::STATUS_CANCELLED);
    }

    public function isCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    protected $fillable = [
        'user_id',
        'downloads_earnings',
        'referrals_earnings',
        'total',
        'method',
        'account',
        'status',
        'is_viewed',
    ];

    public function statusName()
    {
        if ($this->status == self::STATUS_PENDING) {
            return translate('Pending', 'withdrawals');
        } elseif ($this->status == self::STATUS_RETURNED) {
            return translate('Returned', 'withdrawals');
        } elseif ($this->status == self::STATUS_APPROVED) {
            return translate('Approved', 'withdrawals');
        } elseif ($this->status == self::STATUS_COMPLETED) {
            return translate('Completed', 'withdrawals');
        } elseif ($this->status == self::STATUS_CANCELLED) {
            return translate('Cancelled', 'withdrawals');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}