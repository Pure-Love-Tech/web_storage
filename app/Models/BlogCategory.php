<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    protected $fillable = [
        'lang',
        'name',
        'slug',
        'views',
    ];

    public function blogArticles()
    {
        return $this->hasMany(BlogArticle::class, 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }

}
