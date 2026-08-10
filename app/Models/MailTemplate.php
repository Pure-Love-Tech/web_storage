<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function scopeForLicense($query)
    {
        $query->where('license', '<=', licenseType());
    }

    public function isForLicense()
    {
        return $this->license <= licenseType();
    }

    private const NON_DISABLE_TEMPLATES = [
        'password_reset',
        'email_verification',
    ];

    public function nonDisabled()
    {
        return in_array($this->alias, self::NON_DISABLE_TEMPLATES);
    }

    protected $fillable = [
        'lang',
        'subject',
        'body',
        'status',
    ];

    protected $casts = [
        'shortcodes' => 'object',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}