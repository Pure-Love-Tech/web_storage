<div wire:ignore.self wire:key="editModal" class="modal custom-modal fade" id="editModal" aria-labelledby="editModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><i
                        class="fa fa-edit me-2"></i>{{ translate('Edit details', 'files') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateDetails">
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Name', 'forms') }} : <span
                                class="required">*</span></label>
                        <input type="text" wire:model="name" class="form-control form-control-md radius radius-md"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Visibility', 'forms') }} : <span
                                class="required">*</span></label>
                        <select wire:model="visibility" class="form-select form-select-md radius radius-md">
                            @foreach (\App\Models\FileEntry::getVisibilityOptions() as $visibilityOptionKey => $visibilityOptionValue)
                                <option value="{{ $visibilityOptionKey }}"
                                    {{ $visibilityOptionKey == $visibility ? 'selected' : '' }}>
                                    {{ $visibilityOptionValue }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Password', 'forms') }} :</label>
                        <input wire:model="password" class="form-control form-control-md radius radius-md" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Description', 'forms') }} :</label>
                        <textarea wire:model="description" class="form-control radius radius-md" rows="3"></textarea>
                    </div>
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-lg">
                            <button type="submit"
                                class="btn btn-primary btn-md radius radius-md w-100">{{ translate('Save changes', 'files') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
