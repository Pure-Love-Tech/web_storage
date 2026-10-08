<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    public $timestamps = false;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isManual()
    {
        return $this->is_manual;
    }

    public function isBalance()
    {
        return $this->alias == "balance";
    }

    protected $fillable = [
        'name',
        'logo',
        'credentials',
        'instructions',
        'status',
    ];

    protected $casts = [
        'credentials' => 'object',
        'status' => 'boolean',
    ];
}
