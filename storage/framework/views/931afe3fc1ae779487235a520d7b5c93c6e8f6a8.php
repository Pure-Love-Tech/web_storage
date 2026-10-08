<?php $__env->startSection('title', admin_trans('Edit | ') . $storageProvider->name); ?>
<?php $__env->startSection('section', admin_trans('Settings')); ?>
<?php $__env->startSection('back', route('admin.settings.storage.index')); ?>
<?php $__env->startSection('container', 'container-max-lg'); ?>
<?php $__env->startSection('content'); ?>
    <form id="vironeer-submited-form" action="<?php echo e(route('admin.settings.storage.update', $storageProvider->id)); ?>"
        method="POST">
        <?php echo csrf_field(); ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="vironeer-file-preview-box bg-light mb-3 p-4 text-center">
                    <div class="file-preview-box mb-3">
                        <img id="filePreview" src="<?php echo e(asset($storageProvider->logo)); ?>" height="100px" height="100px">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo e(admin_trans('Name')); ?> </label>
                        <input class="form-control" value="<?php echo e($storageProvider->name); ?>" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo e(admin_trans('Status')); ?></label>
                        <input type="checkbox" name="status" data-toggle="toggle"
                            <?php if($storageProvider->status): ?> checked <?php endif; ?>>
                    </div>
                </div>
            </div>
        </div>
        <?php if($storageProvider->instructions): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="far fa-question-circle me-2"></i><?php echo e($storageProvider->name . admin_trans(' Instructions')); ?>

                </div>
                <div class="card-body">
                    <?php echo str_replace('[URL]', url('/'), $storageProvider->instructions); ?>

                </div>
            </div>
        <?php endif; ?>
        <?php if($storageProvider->credentials): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa fa-key me-2"></i> <?php echo e($storageProvider->name . admin_trans(' Credentials')); ?>

                </div>
                <div class="card-body">
                    <div class="row g-3 pb-2">
                        <?php $__currentLoopData = $storageProvider->credentials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-12">
                                <label class="form-label capitalize">
                                    <?php echo e(str_replace('_', ' ', $key)); ?> :
                                </label>
                                <input type="text" name="credentials[<?php echo e($key); ?>]"
                                    value="<?php echo e(demoMode() ? '' : $value); ?>" class="form-control remove-spaces">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </form>
    <?php if($storageProvider->status): ?>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-hdd me-2"></i> <?php echo e(admin_trans('Test Connection')); ?>

            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.settings.storage.test', $storageProvider->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button
                        class="vironeer-form-confirm btn btn-success"><?php echo e(admin_trans('Test ') . $storageProvider->name); ?>

                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/settings/storage/edit.blade.php ENDPATH**/ ?>