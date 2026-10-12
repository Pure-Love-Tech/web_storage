<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    protected $fillable = [
        'lang',
        'title',
        'body',
        'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}
