<div wire:ignore.self wire:key="createFolderModal" class="modal custom-modal fade" id="createFolderModal"
    aria-labelledby="createFolderModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFolderModalLabel">{{ translate('New Folder', 'files') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="createFolder">
                    <div class="mb-4">
                        <label class="form-label">{{ translate('Folder name', 'forms') }} : <span
                                class="required">*</span></label>
                        <input type="text" wire:model="folder_name"
                            class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('Folder name', 'files') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ translate('Visibility', 'forms') }} : <span
                                class="required">*</span></label>
                        <select wire:model="visibility" class="form-select form-select-md radius radius-md" required>
                            @foreach (\App\Models\FileEntry::getVisibilityOptions() as $visibilityOptionKey => $visibilityOptionValue)
                                <option value="{{ $visibilityOptionKey }}" @selected($loop->first)>
                                    {{ $visibilityOptionValue }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-lg">
                            <button type="submit"
                                class="btn btn-primary btn-md radius radius-md w-100">{{ translate('Create', 'files') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
