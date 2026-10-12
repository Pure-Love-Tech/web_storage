<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;

class FolderController extends Controller
{
    public function index($id)
    {
        $fileEntry = FileEntry::whereHashId($id)->with(['children' => function ($query) {
            $query->orderByRaw("FIELD(type, 'folder') DESC, updated_at DESC")
                ->orderbyDesc('id');
        }])->folder()->public()->firstOrFail();
        return theme_view('files.folder', ['fileEntry' => $fileEntry]);
    }
}
