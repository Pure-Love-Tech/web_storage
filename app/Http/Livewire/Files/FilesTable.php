<?php

namespace App\Http\Livewire\Files;

use App\Models\FileEntry;
use App\Traits\LivewireToastr;
use App\Traits\WithPagination;
use Livewire\Component;

class FilesTable extends Component
{
    use WithPagination, LivewireToastr;

    /**
     * The currently authenticated user.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The file entry instance being viewed or edited.
     */
    public $fileEntry;

    /**
     * The array of file entry IDs being displayed.
     */
    public $fileEntriesIds;

    /**
     * The total number of file entries being displayed.
     */
    public $fileEntriesCount;

    /**
     * The ID of the folder being displayed.
     */
    public $folder_id;

    /**
     * The search query for filtering file entries.
     */
    public $search = '';

    /**
     * The ID of the file entry to be deleted.
     */
    public $delete_id;

    /**
     * Indicates whether all rows are selected.
     */
    public $selectAllRows = false;

    /**
     * The array of IDs for the selected rows.
     */
    public $selectedRows = [];

    /**
     * The event listeners for the component.
     */
    protected $listeners = [
        'refreshEntries' => '$refresh', // Refresh the file entries list.
        'deselectall' => 'deselectAllRows', // Deselect all rows.
        'deleteOneConfirmed' => 'deleteOne', // Delete a single file entry.
        'deleteMultipleConfirmed' => 'deleteMultiple', // Delete multiple file entries.
    ];

    /**
     * Mount the component.
     */
    public function mount()
    {
        // Get the authenticated user information.
        $this->user = auth()->user();

        // If a folder ID is provided in the request, set it as the current folder ID.
        if (request()->filled('folder')) {
            $this->folder_id = request('folder');
        }
    }

    /**
     * Refresh the file entries list.
     */
    public function refreshEntries()
    {
        $this->emit('refreshEntries');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        // Build a query for file entries.
        $fileEntries = FileEntry::query();

        // Retrieve the current folder or display all entries with no parent.
        $folder = null;
        if ($this->folder_id) {
            $folder = FileEntry::where('id', $this->folder_id)->forUser($this->user->id)->first();
            $fileEntries->where('parent_id', $this->folder_id);
        } else {
            $fileEntries->hasNoParent();
        }

        // Filter file entries by the search query if one is provided.
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $fileEntries->where('name', 'like', $searchTerm)
                ->orWhere('description', 'like', $searchTerm);
        }

        // Retrieve file entries for the current user and order them.
        $fileEntries = $fileEntries->forUser($this->user->id)
            ->orderByRaw("FIELD(type, 'folder') DESC, updated_at DESC")
            ->orderbyDesc('id')
            ->paginate(20);

        // Set the list of file entry IDs and the total count of file entries.
        $this->fileEntriesIds = $fileEntries->pluck('id')->map(fn($id) => (string) $id);
        $this->fileEntriesCount = $fileEntries->count();

        // Render the view for the component.
        return theme_view('livewire.files.files-table', [
            'folder' => $folder,
            'fileEntries' => $fileEntries,
        ]);
    }

    /**
     * Updates the selected rows array based on the select all rows value.
     *
     * @param bool $value Whether all rows are selected or not.
     *
     * @return void
     */
    public function updatedSelectAllRows($value)
    {
        // If all rows are selected, set the selected rows array to all file entries' IDs
        // Otherwise, empty the selected rows array
        if ($value) {
            $this->selectedRows = $this->fileEntriesIds;
        } else {
            $this->selectedRows = [];
        }
    }

    /**
     * Updates the select all rows value based on the selected rows array.
     *
     * @return void
     */
    public function updatedSelectedRows()
    {
        // If the number of selected rows equals the total number of file entries, set select all rows to true
        $this->selectAllRows = count($this->selectedRows) === $this->fileEntriesCount;
    }

    /**
     * Adds the given ID to the selected rows array.
     *
     * @param int $id The ID of the row to be selected.
     *
     * @return void
     */
    public function selectRow($id)
    {
        $this->selectedRows[] = (string) $id;
    }

    /**
     * Removes the given ID from the selected rows array.
     *
     * @param int $id The ID of the row to be deselected.
     *
     * @return void
     */
    public function deselectRow($id)
    {
        // Remove the given ID from the selected rows array
        $this->selectedRows = array_diff($this->selectedRows, [(string) $id]);
    }

    /**
     * Deselects all rows by emptying the selected rows array and setting select all rows to false.
     *
     * @return void
     */
    public function deselectAllRows()
    {
        $this->selectAllRows = false;
        $this->selectedRows = [];
    }

    /**
     * Shows a move modal for files and folders.
     *
     * @param int|null $id The ID of the selected item, if any.
     *
     * @return void
     */
    public function showMoveModal($id = null)
    {
        // Check if an ID was provided, otherwise get the selected rows
        if (!$id) {
            // If no rows were selected, show an error message
            if (count($this->selectedRows) < 1) {
                return $this->toastr('error', translate('You did not select any files or folders', 'files'));
            }
            // Otherwise, get the selected rows' IDs
            $ids = $this->selectedRows;
        } else {
            // If an ID was provided, use it as the only selected item
            $ids = [$id];
        }
        // Dispatch a browser event to show the move modal with the selected item(s)
        $this->dispatchBrowserEvent('show-move-modal', ['ids' => $ids]);
    }

    /**
     * Shows a confirmation dialog for deleting multiple files and folders.
     *
     * @return void
     */
    public function deleteMultipleConfirm()
    {
        // If no rows were selected, show an error message
        if (count($this->selectedRows) < 1) {
            return $this->toastr('error', translate('You did not select any files or folders', 'files'));
        }
        // Dispatch a browser event to show the delete confirmation dialog with the selected item(s)
        $this->dispatchBrowserEvent('delete-multiple-confirm', ['ids' => $this->selectedRows]);
    }

    /**
     * Deletes multiple files and folders with the given IDs.
     *
     * @param array $ids The IDs of the items to be deleted.
     *
     * @return void
     */
    public function deleteMultiple($ids)
    {
        foreach ($ids as $id) {
            // Get the FileEntry with the given ID that belongs to the current user and is not expired
            $fileEntry = FileEntry::where('id', $id)->forUser($this->user->id)->first();
            if ($fileEntry) {
                // Delete the file or folder and its contents recursively
                $fileEntry->deleteRecursive();
            }
        }
        // Deselect all rows after deletion and show a success message
        $this->selectAllRows = false;
        $this->selectedRows = [];
        return $this->toastr('success', translate('Deleted successfully', 'files'));
    }

    /**
     * Shows a confirmation dialog for deleting a single file or folder with the given ID.
     *
     * @param int $id The ID of the item to be deleted.
     *
     * @return void
     */
    public function deleteOneConfirm($id)
    {
        // Set the ID of the item to be deleted and dispatch a browser event to show the delete confirmation dialog
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-one-confirm');
    }

    /**
     * Deletes a single file or folder with the ID set in the delete_id property.
     *
     * @return void
     */
    public function deleteOne()
    {
        // Get the FileEntry with the ID set in the delete_id property that belongs to the current user and is not expired
        $fileEntry = FileEntry::where('id', $this->delete_id)->forUser($this->user->id)->first();
        if ($fileEntry) {
            // Delete the file or folder and its contents recursively
            $fileEntry->deleteRecursive();
        }
        // Show a success message
        return $this->toastr('success', translate('Deleted successfully', 'files'));
    }

}
