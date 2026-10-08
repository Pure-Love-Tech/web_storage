<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    use HasFactory;

    protected $table = "footer_menu";

    public function scopeByOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    protected $fillable = [
        'lang',
        'name',
        'link',
        'parent_id',
        'order',
    ];

    public function children()
    {
        return $this->hasMany(FooterMenu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(FooterMenu::class, 'parent_id');
    }
}
