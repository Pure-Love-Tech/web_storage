<?php $__env->startSection('title', translate('Server Error', 'errors')); ?>
<?php $__env->startSection('code', '500'); ?>
<?php $__env->startSection('message', translate('Server error message', 'errors')); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/vendor/errors/500.blade.php ENDPATH**/ ?>