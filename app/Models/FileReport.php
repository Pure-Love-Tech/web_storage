<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_entry_id',
        'ip',
        'name',
        'email',
        'reason',
        'details',
        'is_viewed',
    ];

    public static function reasons()
    {
        return [
            0 => translate('Privacy, copyright or legal complaints', 'download pages'),
            1 => translate('Spam or misleading', 'download pages'),
            2 => translate('Malware, virus or malicious content', 'download pages'),
            3 => translate('Child abuse', 'download pages'),
            4 => translate('Other', 'download pages'),
        ];
    }

    public function file_entry()
    {
        return $this->belongsTo(FileEntry::class);
    }
}