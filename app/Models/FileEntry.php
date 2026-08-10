<?php

namespace App\Models;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{
    use HasFactory;

    const VISIBILITY_PUBLIC = 1;
    const VISIBILITY_PRIVATE = 0;

    const TYPE_FOLDER = "folder";
    const TYPE_FILE = "file";

    protected $touches = ['parent'];

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForUsers($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function isForUser()
    {
        return $this->user_id != null;
    }

    public function scopeForVisitor($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeForVisitors($query)
    {
        return $query->whereNull('user_id');
    }

    public function isForVisitor()
    {
        return $this->user_id == null;
    }

    public function scopeWhereHashId($query, $id)
    {
        return $query->where('id', unhashid($id));
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', self::VISIBILITY_PUBLIC);
    }

    public function isPublic()
    {
        return $this->visibility == self::VISIBILITY_PUBLIC;
    }

    public function scopePrivate($query)
    {
        return $query->where('visibility', self::VISIBILITY_PRIVATE);
    }

    public function isPrivate()
    {
        return $this->visibility == self::VISIBILITY_PRIVATE;
    }

    public function scopeInactive($query)
    {
        return $query->whereNotNull('expiry_at')->where('expiry_at', '<', Carbon::now());
    }

    public function scopeFolder($query)
    {
        $query->where('type', self::TYPE_FOLDER);
    }

    public function isFolder()
    {
        return $this->type == self::TYPE_FOLDER;
    }

    public function scopeFile($query)
    {
        $query->where('type', self::TYPE_FILE);
    }

    public function isFile()
    {
        return $this->type == self::TYPE_FILE;
    }

    public function scopeHasNoParent($query)
    {
        $query->whereNull('parent_id');
    }

    public function hasParent()
    {
        return $this->parent_id ? true : false;
    }

    public function hasPassword()
    {
        return $this->password ? true : false;
    }

    protected $fillable = [
        'user_id',
        'parent_id',
        'storage_provider_id',
        'ip',
        'name',
        'description',
        'filename',
        'mime',
        'size',
        'extension',
        'type',
        'password',
        'path',
        'path_ids',
        'downloads',
        'visibility',
        'expiry_at',
        'is_viewed',
    ];

    protected $casts = [
        'expiry_at' => 'datetime',
    ];

    public function sharedId()
    {
        return hashid($this->id);
    }

    public function sharedLink()
    {
        if ($this->isFolder()) {
            return route('files.folder', $this->sharedId());
        }
        return route('files.file', $this->sharedId());
    }

    public function downloadFile()
    {
        $handler = new $this->storageProvider->handler;
        return $handler->download($this);
    }

    public function updateExpiryDate()
    {
        $plan = Plan::query();
        if ($this->user) {
            $user = $this->user;
            if ($user->isSubscribed() && !$user->subscription->isExpired()) {
                $plan = $plan->Premium();
            } else {
                $plan = $plan->forUsers();
            }
        } else {
            $plan = $plan->forVisitors();
        }
        $plan = $plan->first();
        if ($plan->file_expiry_days) {
            $this->expiry_at = Carbon::now()->addDays($plan->file_expiry_days);
            $this->update();
        }
    }

    public function getFullName()
    {
        if ($this->isFile() && $this->extension) {
            return $this->name . '.' . $this->extension;
        }
        return $this->name;
    }

    public function getFullPathAttribute()
    {
        $path = $this->name;

        $parent = $this->parent;
        while ($parent) {
            $path = $parent->name . '/' . $path;
            $parent = $parent->parent;
        }

        return $path . '/';
    }

    public function getSize()
    {
        $size = $this->size;
        if ($this->isFolder()) {
            foreach ($this->children as $child) {
                $size += $child->getSize();
            }
        }
        return $size;
    }

    public function getFullSize()
    {
        $size = $this->size;
        if ($this->isFolder()) {
            $subFolders = $this->children()->folder()->get();
            foreach ($subFolders as $subFolder) {
                $size += $subFolder->getSize();
            }
            $files = $this->children()->file()->get();
            foreach ($files as $file) {
                $size += $file->size;
            }
        }
        return formatBytes($size);
    }

    public function getFileIcon($size = null)
    {
        if ($this->isFolder()) {
            return '<i class="fa-solid fa-folder-closed ' . $size . '"></i>';
        } else {
            $extension = $this->extension ? $this->extension : $this->name;
            return '<span class="vi vi-file ' . $size . '" data-type="' . substr($extension, 0, 4) . '"></span>';
        }
    }

    public function visibility()
    {
        return $this->getVisibilityOptions()[$this->visibility];
    }

    public static function getVisibilityOptions()
    {
        return [
            self::VISIBILITY_PUBLIC => translate('Public', 'file system'),
            self::VISIBILITY_PRIVATE => translate('Private', 'file system'),
        ];
    }

    public function setPathIds()
    {
        if (!$this->parent) {
            $this->path_ids = $this->id;
        } else {
            $this->path_ids = $this->parent->path_ids . '/' . $this->id;
        }
        $this->update();
    }

    public static function getUniqueEntryName($name, $parent_id, $userId = null)
    {
        $counter = 1;
        $originalName = $name;
        while (FileEntry::where('name', $name)->where('parent_id', $parent_id)->forUser($userId)->exists()) {
            $name = $originalName . ' (' . $counter++ . ')';
        }
        return $name;
    }

    public function countFoldersRecursive()
    {
        $count = 0;
        if ($this->isFolder()) {
            foreach ($this->children as $child) {
                if ($child->isFolder()) {
                    $count += $child->countFoldersRecursive() + 1;
                }
            }
        }
        return $count;
    }

    public function countFilesRecursive()
    {
        $count = 0;
        if ($this->isFolder()) {
            foreach ($this->children as $child) {
                if ($child->isFolder()) {
                    $count += $child->countFilesRecursive();
                } else {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function deleteRecursive()
    {
        if ($this->isFolder()) {
            if ($this->children->count() > 0) {
                foreach ($this->children as $child) {
                    if ($child->isFolder()) {
                        $child->deleteRecursive();
                    } else {
                        $handler = new $child->storageProvider->handler;
                        if ($handler->delete($child->path)) {
                            $child->delete();
                        }
                    }
                }
            }
            $this->delete();
        }

        if ($this->isFile()) {
            $handler = new $this->storageProvider->handler;
            if ($handler->delete($this->path)) {
                $this->delete();
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(FileEntry::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FileEntry::class, 'parent_id');
    }

    public function storageProvider()
    {
        return $this->belongsTo(StorageProvider::class);
    }

}
