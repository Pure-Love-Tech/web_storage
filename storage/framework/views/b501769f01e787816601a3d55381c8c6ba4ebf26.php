<div wire:ignore.self wire:key="createFolderModal" class="modal custom-modal fade" id="createFolderModal"
    aria-labelledby="createFolderModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFolderModalLabel"><?php echo e(translate('New Folder', 'files')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="createFolder">
                    <div class="mb-4">
                        <label class="form-label"><?php echo e(translate('Folder name', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <input type="text" wire:model="folder_name"
                            class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('Folder name', 'files')); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><?php echo e(translate('Visibility', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <select wire:model="visibility" class="form-select form-select-md radius radius-md" required>
                            <?php $__currentLoopData = \App\Models\FileEntry::getVisibilityOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visibilityOptionKey => $visibilityOptionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($visibilityOptionKey); ?>" <?php if($loop->first): echo 'selected'; endif; ?>>
                                    <?php echo e($visibilityOptionValue); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-lg">
                            <button type="submit"
                                class="btn btn-primary btn-md radius radius-md w-100"><?php echo e(translate('Create', 'files')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/livewire/files/folder-modal.blade.php ENDPATH**/ ?>