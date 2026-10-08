<div wire:ignore.self wire:key="moveModal" class="modal custom-modal fade" id="moveModal" aria-labelledby="moveModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moveModalLabel"><?php echo e(translate('Move to', 'files')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="moveEntries">
                    <input id="ids" type="text" wire:model="ids" hidden>
                    <div class="mb-4">
                        <select wire:model="folder" class="form-select form-select-md radius radius-md">
                            <option value="">/</option>
                            <?php $__currentLoopData = $folderOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($option['value']); ?>">
                                    <?php echo e($option['label']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="row justify-content-center g-3">
                        <div class="col-12 col-lg">
                            <button type="submit"
                                class="btn btn-primary btn-md radius radius-md w-100"><?php echo e(translate('Move', 'files')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/livewire/files/move-modal.blade.php ENDPATH**/ ?>