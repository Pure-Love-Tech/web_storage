<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadSession extends Model
{
    public const STATUS_INITIATED = 'initiated';
    public const STATUS_UPLOADING = 'uploading';
    public const STATUS_COMPLETING = 'completing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_ABORTED = 'aborted';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'token',
        'user_id',
        'storage_provider_id',
        'file_entry_id',

        'r2_upload_id',
        'object_key',

        'filename',
        'original_name',

        'name',
        'mime',
        'extension',

        'size',

        'part_size',
        'total_parts',

        'parent_id',

        'visibility',
        'password',
        'description',

        'ip',

        'status',
        'error',

        'expires_at',
        'completed_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'storage_provider_id' => 'integer',
        'file_entry_id' => 'integer',

        'size' => 'integer',
        'part_size' => 'integer',
        'total_parts' => 'integer',

        'parent_id' => 'integer',

        'visibility' => 'boolean',

        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function fileEntry()
    {
        return $this->belongsTo(FileEntry::class);
    }

    public function storageProvider()
    {
        return $this->belongsTo(StorageProvider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at &&
            now()->greaterThan($this->expires_at);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
