<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalMethod extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    protected $fillable = [
        'name',
        'logo',
        'minimum',
        'description',
        'sort_id',
        'status',
    ];
}
