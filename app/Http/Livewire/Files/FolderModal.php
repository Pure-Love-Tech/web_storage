<?php

namespace App\Http\Livewire\Files;

use App\Models\FileEntry;
use App\Traits\LivewireToastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FolderModal extends Component
{
    use LivewireToastr;

    /**
     * The currently authenticated user.
     *
     * @var User
     */
    public $user;

    /**
     * The ID of the parent folder to which the new folder will belong.
     *
     * @var int|null
     */
    public $parent_id;

    /**
     * The name of the new folder.
     *
     * @var string|null
     */
    public $folder_name;

    /**
     * The visibility of the new folder.
     *
     * @var int
     */
    public $visibility = 1;

    /**
     * Mount the component and set the parent ID value if a 'folder' request is present.
     *
     * @return void
     */
    public function mount()
    {
        // Set the $user property to the currently authenticated user
        $this->user = auth()->user();

        if (request()->filled('folder')) {
            $this->parent_id = request('folder');
        }
    }

    /**
     * Define the validation rules for the input values.
     *
     * @return array
     */
    public function rules()
    {
        // Define the validation rules
        return [
            'parent_id' => ['nullable', 'exists:file_entries,id,user_id,' . $this->user->id],
            'folder_name' => ['required', 'string', 'max:255', 'block_patterns'],
            'visibility' => ['required', 'boolean'],
        ];
    }

    /**
     * Create a new folder for the authenticated user and validate the inputs before doing so.
     *
     * @return void
     */
    public function createFolder()
    {
        // Validate the input values against the defined rules
        $validator = Validator::make([
            'parent_id' => $this->parent_id,
            'folder_name' => $this->folder_name,
            'visibility' => $this->visibility,
        ], $this->rules());

        // If validation fails, display the error messages and return
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        // Check the subscription expired
        if (subscription()->is_expired) {
            return $this->toastr('error', translate('Your subscription has expired', 'settings'));
        }

        // Get the next available folder name with a number appended if necessary
        $name = FileEntry::getUniqueEntryName($this->folder_name, $this->parent_id, $this->user->id);

        // Create a new file entry for the folder
        $fileEntry = FileEntry::create([
            'ip' => ipInfo()->ip,
            'user_id' => $this->user->id,
            'parent_id' => $this->parent_id,
            'name' => $name,
            'filename' => $this->folder_name,
            'type' => FileEntry::TYPE_FOLDER,
            'visibility' => $this->visibility,
            'is_viewed' => true,
        ]);

        // If file entry creation was successful, reset the folder name field,
        // Display success message, close modal, and emit an event to refresh the files
        if ($fileEntry) {
            $fileEntry->setPathIds();
            $this->folder_name = "";
            $this->dispatchBrowserEvent('close-modal', ['id' => 'createFolderModal']);
            $this->emit('refreshEntries');
            return $this->toastr('success', translate('Folder created successfully', 'files'));
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return theme_view('livewire.files.folder-modal');
    }

}
