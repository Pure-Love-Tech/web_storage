<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'capital',
        'continent',
        'continent_code',
        'phone',
        'currency',
        'symbol',
        'alpha_3',
    ];
}
