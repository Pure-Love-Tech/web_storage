<?php

namespace App\Http\Livewire\Files;

use App\Models\FileEntry;
use App\Traits\LivewireToastr;
use Livewire\Component;

class ShareModal extends Component
{
    use LivewireToastr;

    /**
     * The currently authenticated user.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The file entry
     *
     * @var string
     */
    public $fileEntry = null;

    /**
     * The event listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        'shareFileEntry' => 'getFileEntryDetails',
    ];

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount()
    {
        // Get the currently authenticated user
        $this->user = auth()->user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Render the component view and pass the file entry
        return theme_view('livewire.files.share-modal', ['fileEntry' => $this->fileEntry]);
    }

    /**
     * Get the file entry for a given ID and set the social media links.
     *
     * @param int $id The ID of the file entry.
     * @return void
     */
    public function getFileEntryDetails($id)
    {
        // Find the file entry for the given ID and user
        $fileEntry = FileEntry::where('id', $id)->forUser($this->user->id)->first();

        // If the file entry doesn't exist, show an error message
        if (!$fileEntry) {
            return $this->toastr('error', translate('The selected file or folder is not exists', 'files'));
        }

        // Set the file entry for this object.
        $this->fileEntry = $fileEntry;

        //Dispatches a browser event to show the share modal.
        return $this->dispatchBrowserEvent('show-share-modal');
    }
}
