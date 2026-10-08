<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'flag',
        'amount',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
