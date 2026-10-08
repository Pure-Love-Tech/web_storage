<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referring_user_id',
        'referred_user_id',
        'earnings',
    ];

    public function referring_user()
    {
        return $this->belongsTo(User::class, 'referring_user_id');
    }

    public function referred_user()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
