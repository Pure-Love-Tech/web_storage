<?php $__env->startSection('section', admin_trans('Users')); ?>
<?php $__env->startSection('title', admin_trans('Add new user')); ?>
<?php $__env->startSection('container', 'container-max-lg'); ?>
<?php $__env->startSection('back', route('admin.members.users.index')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <?php echo e(admin_trans('User details')); ?>

        </div>
        <div class="card-body">
            <form id="vironeer-submited-form" action="<?php echo e(route('admin.members.users.store')); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="avatar text-center py-4">
                    <div>
                        <img id="filePreview" src="<?php echo e(asset('images/avatars/default.png')); ?>" class="rounded-circle mb-3"
                            width="110" height="110">
                        <input id="selectedFileInput" type="file" name="avatar"
                            accept="image/png, image/jpg, image/jpeg" hidden>
                    </div>
                    <button id="selectFileBtn" type="button" class="btn btn-secondary"><i
                            class="fas fa-camera me-2"></i><?php echo e(admin_trans('Choose Image')); ?></button>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(admin_trans('Username')); ?></label>
                    <input type="username" name="username" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(admin_trans('E-mail Address')); ?></label>
                    <input type="email" name="email" class="form-control form-control-lg" required>
                </div>
                <div class="mb-2">
                    <label class="form-label"><?php echo e(admin_trans('Password')); ?></label>
                    <input type="text" name="password" class="form-control form-control-lg" required>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/members/users/create.blade.php ENDPATH**/ ?>