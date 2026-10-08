<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageProvider extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function isLocal()
    {
        return $this->alias === "local";
    }

    public function isDefault()
    {
        return $this->is_default == 1;
    }

    public function scopeDefault($query)
    {
        $query->where('is_default', 1);
    }

    protected $fillable = [
        'name',
        'symbol',
        'logo',
        'credentials',
        'status',
        'is_default',
    ];

    protected $casts = [
        'credentials' => 'object',
    ];

}
