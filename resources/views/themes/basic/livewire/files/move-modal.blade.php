<div wire:ignore.self wire:key="moveModal" class="modal custom-modal fade" id="moveModal" aria-labelledby="moveModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moveModalLabel">{{ translate('Move to', 'files') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="moveEntries">
                    <input id="ids" type="text" wire:model="ids" hidden>
                    <div class="mb-4">
                        <select wire:model="folder" class="form-select form-select-md radius radius-md">
                            <option value="">/</option>
                            @foreach ($folderOptions as $option)
                                <option value="{{ $option['value'] }}">
                                    {{ $option['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-lg">
                            <button type="submit"
                                class="btn btn-primary btn-md radius radius-md w-100">{{ translate('Move', 'files') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
