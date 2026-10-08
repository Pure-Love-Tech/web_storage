<?php $__env->startSection('title', translate('Forbidden', 'errors')); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('message', translate('Forbidden error message', 'errors')); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/vendor/errors/403.blade.php ENDPATH**/ ?>