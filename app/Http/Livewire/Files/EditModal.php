<?php

namespace App\Http\Livewire\Files;

use App\Models\FileEntry;
use App\Traits\LivewireToastr;
use Livewire\Component;
use Validator;

class EditModal extends Component
{
    use LivewireToastr;

    /**
     * The currently authenticated user.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The ID of the file entry.
     *
     * @var int
     */
    public $file_entry_id;

    /**
     * The name of the file entry.
     *
     * @var string
     */
    public $name;

    /**
     * The visibility status of the file entry.
     *
     * @var int
     */
    public $visibility = 0;

    /**
     * The password to access the file entry (if any).
     *
     * @var string|null
     */
    public $password;

    /**
     * The description of the file entry (if any).
     *
     * @var string|null
     */
    public $description;

    /**
     * The listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        'editFileEntry' => 'getFileEntryDetails',
    ];

    /**
     * Mount the component.
     *
     * Set the authenticated user to the $user property.
     *
     * @return void
     */
    public function mount()
    {
        $this->user = auth()->user();
    }

    /**
     * Get the validation rules that apply to the component.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'block_patterns'],
            'visibility' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000', 'block_patterns'],
        ];
    }

    /**
     * Render the Livewire component's view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return theme_view('livewire.files.edit-modal');
    }

    /**
     * Get the details of a file entry.
     *
     * @param  int  $id  The ID of the file entry.
     * @return void
     */
    public function getFileEntryDetails($id)
    {
        // Retrieve the file entry from the database.
        $fileEntry = FileEntry::where('id', $id)->forUser($this->user->id)->first();

        // If the file entry does not exist, return an error message.
        if (!$fileEntry) {
            return $this->toastr('error', translate('The selected file or folder is not exists', 'files'));
        }

        // Set the component properties based on the retrieved file entry.
        $this->file_entry_id = $fileEntry->id;
        $this->name = $fileEntry->name;
        $this->visibility = $fileEntry->visibility ? 1 : 0;
        $this->password = $fileEntry->password;
        $this->description = $fileEntry->description;

        // Dispatch a browser event to show the edit modal.
        return $this->dispatchBrowserEvent('show-edit-modal');
    }

    /**
     * Updates the details of a file entry.
     * @return mixed
     */
    public function updateDetails()
    {
        // Validate the user input against the defined rules.
        $validator = Validator::make([
            'name' => $this->name,
            'visibility' => $this->visibility,
            'password' => $this->password,
            'description' => $this->description,
        ], $this->rules());

        // If the validation fails, return an error message.
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        // Find the file entry that is being updated.
        $fileEntry = FileEntry::where('id', $this->file_entry_id)->forUser($this->user->id)->first();

        // If the file entry doesn't exist, return an error message.
        if (!$fileEntry) {
            return $this->toastr('error', translate('The selected file or folder is not exists', 'files'));
        }

        // Get the new name for the file entry.
        $name = ($this->name != $fileEntry->name) ? FileEntry::getUniqueEntryName($this->name, $fileEntry->parent_id, $this->user->id) : $this->name;

        // Update the file entry with the new details.
        $fileEntry->name = $name;
        $fileEntry->visibility = $this->visibility;
        $fileEntry->password = $this->password;
        $fileEntry->description = $this->description;
        $fileEntry->update();

        // Dispatch a browser event to close the edit modal.
        $this->dispatchBrowserEvent('close-modal', ['id' => 'editModal']);

        // Emit an event to refresh the file entries list.
        $this->emit('refreshEntries');

        // Return a success message.
        return $this->toastr('success', translate('Details updated successfully', 'files'));
    }

}
