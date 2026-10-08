<?php $__env->startSection('title', admin_trans('Report') . ' | #' . $fileReport->id); ?>
<?php $__env->startSection('back', route('admin.files.reports.index')); ?>
<?php $__env->startSection('container', 'container-max-lg'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card mb-2">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <?php
                    $fileEntry = $fileReport->file_entry;
                    $link = route($fileEntry->user_id ? 'admin.files.users.show' : 'admin.files.visitors.show', $fileEntry->id);
                ?>
                <div class="flex-shrink-0">
                    <a href="<?php echo e($link); ?>" target="_blank">
                        <?php echo $fileEntry->getFileIcon(); ?>

                    </a>
                </div>
                <div class="flex-grow-1 ms-3">
                    <a href="<?php echo e($link); ?>" target="_blank" class="text-dark">
                        <h5 class="mb-1">
                            <?php echo e(shortertext($fileEntry->getFullName(), 50)); ?>

                        </h5>
                        <p class="mb-0 text-muted">
                            <?php echo e(shortertext($fileEntry->mime, 50) ?? admin_trans('Unknown')); ?>

                        </p>
                    </a>
                </div>
                <div class="flex-grow-3 ms-3">
                    <a href="<?php echo e($link); ?>" target="_blank" class="btn btn-primary" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>
                        <?php echo e(admin_trans('View file details')); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <label class="form-label"><?php echo e(admin_trans('Name')); ?></label>
                    <input type="name" class="form-control form-control-lg" value="<?php echo e($fileReport->name); ?>" readonly>
                </div>
                <div class="col-lg-6">
                    <label class="form-label"><?php echo e(admin_trans('Email')); ?></label>
                    <input type="email" class="form-control form-control-lg" value="<?php echo e($fileReport->email); ?>" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php echo e(admin_trans('Reason for reporting')); ?></label>
                <input type="email" class="form-control form-control-lg"
                    value="<?php echo e(\App\Models\FileReport::reasons()[$fileReport->reason]); ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php echo e(admin_trans('Details')); ?></label>
                <textarea class="form-control" rows="8" readonly><?php echo e($fileReport->details); ?></textarea>
            </div>
            <form action="<?php echo e(route('admin.files.reports.destroy', $fileReport->id)); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="vironeer-able-to-delete btn btn-danger btn-lg w-100"><i
                        class="far fa-trash-alt me-2"></i><?php echo e(admin_trans('Delete')); ?></button>
            </form>
        </div>
    </div>
    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/vironeer/vironeer-icons.min.css')); ?>">
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/files/reports/show.blade.php ENDPATH**/ ?>