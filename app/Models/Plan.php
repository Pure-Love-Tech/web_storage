<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public $timestamps = false;

    const VISITORS_PLAN = 'visitors';
    const USERS_PLAN = 'users';
    const PREMIUM_PLAN = 'premium';

    const UPLOAD_ACTIVE = 1;
    const UPLOAD_DISABLED = 0;

    public function scopeUploadActive($query)
    {
        $query->where('upload_status', self::UPLOAD_ACTIVE);
    }

    public function scopeForVisitors($query)
    {
        return $query->where('alias', self::VISITORS_PLAN);
    }

    public function isForVisitors()
    {
        return $this->alias == self::VISITORS_PLAN;
    }

    public function scopeForUsers($query)
    {
        return $query->where('alias', self::USERS_PLAN);
    }

    public function isForUsers()
    {
        return $this->alias == self::USERS_PLAN;
    }

    public function scopePremium($query)
    {
        return $query->where('alias', self::PREMIUM_PLAN);
    }

    public function isPremium()
    {
        return $this->alias == self::PREMIUM_PLAN;
    }

    protected $fillable = [
        'name',
        'short_description',
        'storage_space',
        'max_file_size',
        'file_expiry_days',
        'download_waiting_time',
        'advertisements',
        'download_captcha',
        'upload_status',
        'sort_id',
    ];

    protected $casts = [
        'storage_space' => 'integer',
        'max_file_size' => 'integer',
        'file_expiry_days' => 'integer',
        'download_waiting_time' => 'integer',
    ];

    public function getStorageSpace()
    {
        return $this->storage_space ? ($this->storage_space * 1024 * 1024) : null;
    }

    public function storageSpaceFormatted()
    {
        $bytes = $this->getStorageSpace();
        if ($bytes === null) {
            return translate('Unlimited', 'premium');
        }
        return formatBytes($bytes);
    }

    public function getMaxFileSize()
    {
        return $this->max_file_size ? ($this->max_file_size * 1024 * 1024) : null;
    }

    public function maxFileSizeFormatted()
    {
        $bytes = $this->getMaxFileSize();
        if ($bytes === null) {
            return translate('Unlimited', 'premium');
        }
        return formatBytes($bytes);
    }

    public function fileExpiryDaysFormatted()
    {
        $days = $this->file_expiry_days;
        if ($days) {
            if ($days == 1) {
                return $days . ' ' . translate('day', 'premium');
            }
            return $days . ' ' . translate('days', 'premium');
        }
        return translate('Never', 'premium');
    }

    public function downloadWaitingTimeFormatted()
    {
        $time = $this->download_waiting_time;
        if ($time) {
            if ($time == 1) {
                return $time . ' ' . translate('second', 'premium');
            }
            return $time . ' ' . translate('seconds', 'premium');
        }
        return '-';
    }

    public function premium_plans()
    {
        return $this->hasMany(PremiumPlan::class);
    }

}
