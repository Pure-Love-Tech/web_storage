<?php

namespace App\Console\Commands\Files;

use App\Models\FileEntry;
use Illuminate\Console\Command;

class DeleteInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:delete-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for deleting the inactive files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fileEntries = FileEntry::inactive()->get();
        if ($fileEntries->count() > 0) {
            foreach ($fileEntries as $fileEntry) {
                $fileEntry->deleteRecursive();
            }
        }
    }
}