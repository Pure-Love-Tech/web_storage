<!DOCTYPE html>
<html lang="<?php echo e(getLocale()); ?>">

<head>
    <?php echo $__env->make('backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/fontawesome/fontawesome.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('vendor/backend/css/colors.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/backend/css/application.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css')); ?>">
</head>

<body>
    <div class="vironeer-sign-container">
        <div class="vironeer-sign-form">
            <div class="card">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('vendor/libs/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/libs/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/backend/js/application.js')); ?>"></script>
    <?php echo app('toastr')->render(); ?>
    <?php if($errors->any()): ?>
        <script>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error('<?php echo e($error); ?>')
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php elseif(session('status')): ?>
        <script>
            toastr.success('<?php echo e(session('status')); ?>')
        </script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/layouts/auth.blade.php ENDPATH**/ ?>