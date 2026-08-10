<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningStatistic extends Model
{
    use HasFactory;

    const SOURCE_DOWNLOAD = 'download';
    const SOURCE_REFERRAL = 'referral';

    const STATUS_INVALID = 0;
    const STATUS_VALID = 1;

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeValid($query)
    {
        return $query->where('status', self::STATUS_VALID);
    }

    public function isValid()
    {
        return $this->status == self::STATUS_VALID;
    }

    public function scopeSourceDownload($query)
    {
        return $query->where('earning_source', self::SOURCE_DOWNLOAD);
    }

    public function scopeSourceReferral($query)
    {
        return $query->where('earning_source', self::SOURCE_REFERRAL);
    }

    protected $fillable = [
        'user_id',
        'earning_statistic_id',
        'ip',
        'country',
        'payout_rate',
        'earning_source',
        'earnings',
        'referral_id',
        'file_entry_id',
        'file_entry_details',
        'referer_domain',
        'referer_details',
        'downloads',
        'status',
        'status_reason',
    ];

    protected $casts = [
        'file_entry_details' => 'object',
        'referer_details' => 'object',
    ];

    public static function status_reasons()
    {
        return [
            1 => translate('Earnings disabled', 'earnings'),
            2 => translate('Direct download', 'earnings'),
            3 => translate('Invalid IP address', 'earnings'),
            4 => translate('Blocked referrer', 'earnings'),
            5 => translate('Downloaded by owner', 'earnings'),
            6 => translate('Missing payout rate', 'earnings'),
            7 => translate('Daily limit reached', 'earnings'),
            8 => translate('Proxy detected', 'earnings'),
            9 => translate('Trustip API error', 'earnings'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file_entry()
    {
        return $this->belongsTo(FileEntry::class);
    }

    public function parent()
    {
        return $this->belongsTo(EarningStatistic::class);
    }

    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }
}
