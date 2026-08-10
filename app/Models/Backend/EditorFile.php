<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];
}