<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'interval',
        'price',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
