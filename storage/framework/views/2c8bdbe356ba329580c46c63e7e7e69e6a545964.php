<div wire:ignore.self wire:key="editModal" class="modal custom-modal fade" id="editModal" aria-labelledby="editModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><i
                        class="fa fa-edit me-2"></i><?php echo e(translate('Edit details', 'files')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateDetails">
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(translate('Name', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <input type="text" wire:model="name" class="form-control form-control-md radius radius-md"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(translate('Visibility', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <select wire:model="visibility" class="form-select form-select-md radius radius-md">
                            <?php $__currentLoopData = \App\Models\FileEntry::getVisibilityOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visibilityOptionKey => $visibilityOptionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($visibilityOptionKey); ?>"
                                    <?php echo e($visibilityOptionKey == $visibility ? 'selected' : ''); ?>>
                                    <?php echo e($visibilityOptionValue); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(translate('Password', 'forms')); ?> :</label>
                        <input wire:model="password" class="form-control form-control-md radius radius-md" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(translate('Description', 'forms')); ?> :</label>
                        <textarea wire:model="description" class="form-control radius radius-md" rows="3"></textarea>
                    </div>
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-lg">
                            <button type="submit"
                                class="btn btn-primary btn-md radius radius-md w-100"><?php echo e(translate('Save changes', 'files')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/livewire/files/edit-modal.blade.php ENDPATH**/ ?>