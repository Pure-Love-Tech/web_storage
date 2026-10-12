<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'lang',
        'title',
        'image',
        'body',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}
