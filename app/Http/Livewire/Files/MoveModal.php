<?php

namespace App\Http\Livewire\Files;

use App\Models\FileEntry;
use App\Traits\LivewireToastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class MoveModal extends Component
{
    use LivewireToastr;

    /**
     * The currently authenticated user.
     *
     * @var User
     */
    public $user;

    /**
     * The IDs of the files to be moved.
     *
     * @var array
     */
    public $ids;

    /**
     * The ID of the folder to move the files to.
     *
     * @var int|null
     */
    public $folder;

    /**
     * Called when the component is first mounted.
     *
     * @return void
     */
    public function mount()
    {
        // Set the $user property to the currently authenticated user
        $this->user = auth()->user();
    }

    /**
     * The validation rules for the form data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'folder' => ['nullable', 'integer',
                Rule::exists('file_entries', 'id')->where(function ($query) {
                    return $query->where('user_id', $this->user->id)
                        ->where('type', FileEntry::TYPE_FOLDER);
                }),
            ],
        ];
    }

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return theme_view('livewire.files.move-modal');
    }

    /**
     * Move file entries to a new folder.
     * @return mixed
     */
    public function moveEntries()
    {
        // Validate that the folder is a valid value according to the rules
        $validator = Validator::make(['folder' => $this->folder], $this->rules());
        if ($validator->fails()) {
            // If validation fails, return an error message
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        // Split the list of file IDs into an array
        $ids = explode(',', $this->ids);

        // Check if any files were selected
        if (count($ids) < 1) {
            // If no files were selected, return an error message
            return $this->toastr('error', translate('You did not select any files or folders', 'files'));
        }

        // Check if the destination folder is one of the selected files
        if (in_array($this->folder, $ids)) {
            // If the destination folder is one of the selected files, return an error message
            return $this->toastr('error', translate('The folder cannot be moved to itself', 'files'));
        }

        // Set the destination folder
        $parent_id = $this->folder ?? null;

        // Loop through each selected file
        foreach ($ids as $id) {

            // Get the file entry for the current file ID, for the current user
            $fileEntry = FileEntry::where('id', $id)->forUser($this->user->id)->first();

            // If the file entry does not exist, return an error message
            if (!$fileEntry) {
                return $this->toastr('error', translate('Some of the selected files or folders are not exist', 'files'));
            }

            // Make sure the target folder is not the current folder
            if ($fileEntry->parent_id == $parent_id) {
                return $this->toastr('error', translate('You cannot move a file or folder to its current location', 'files'));
            }

            // Check if the folder is being moved to one of its child folders
            if ($this->isChildFolder($fileEntry, $parent_id)) {
                return $this->toastr('error', translate('The folder cannot be moved to one of its child folders', 'files'));
            }

            // Get a unique folder name for the new location
            $name = FileEntry::getUniqueEntryName($fileEntry->name, $parent_id, $this->user->id);

            // Update the file entry with the new destination folder and name
            $fileEntry->parent_id = $parent_id;
            $fileEntry->name = $name;
            $fileEntry->save();

            // Set path ids
            $fileEntry->setPathIds();

        }

        // Clear the selected file IDs and destination folder, close the modal, and emit events to refresh the file list and deselect all files
        $this->ids = "";
        $this->folder = "";
        $this->dispatchBrowserEvent('close-modal', ['id' => 'moveModal']);
        $this->emit('refreshEntries');
        $this->emit('deselectall');

        // Return a success message
        return $this->toastr('success', translate('Moved successfully', 'files'));
    }

    /**
     * Checks if a given FileEntry is a child folder of the given parent folder ID.
     *
     * @param FileEntry $fileEntry The FileEntry to check.
     * @param int $parent_id The ID of the parent folder to check against.
     *
     * @return bool Returns true if the FileEntry is a child of the given parent folder, false otherwise.
     */
    public function isChildFolder($fileEntry, $parent_id)
    {
        if (is_null($parent_id)) {
            return false;
        }
        // Get the parent folder for the given ID
        $parentFolder = FileEntry::where('id', $parent_id)->folder()->forUser($this->user->id)->first();

        // Get an array of IDs for each folder in the parent folder's path
        $pathIds = explode('/', $parentFolder->path_ids);

        // Check if the FileEntry's ID is in the list of path IDs
        if (in_array($fileEntry->id, $pathIds)) {
            return true;
        }

        return false;
    }

}
