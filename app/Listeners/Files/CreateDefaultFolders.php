<?php

namespace App\Listeners\Files;

use App\Models\FileEntry;

class CreateDefaultFolders
{
    public function handle($event)
    {
        if (settings('filesystem')->others->default_folders) {
            $folders = explode(',', settings('filesystem')->others->default_folders);
            $user = $event->user;
            foreach ($folders as $folder) {
                $fileEntry = new FileEntry;
                $fileEntry->ip = ipInfo()->ip;
                $fileEntry->user_id = $user->id;
                $fileEntry->name = $folder;
                $fileEntry->filename = $folder;
                $fileEntry->type = FileEntry::TYPE_FOLDER;
                $fileEntry->is_viewed = true;
                $fileEntry->save();
                $fileEntry->setPathIds();
            }
        }
    }
}
