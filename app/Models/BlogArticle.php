<?php

namespace App\Models;

use App\Models\Backend\Admin;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogArticle extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected $fillable = [
        'lang',
        'admin_id',
        'category_id',
        'title',
        'slug',
        'image',
        'content',
        'short_description',
        'views',
    ];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'article_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}
