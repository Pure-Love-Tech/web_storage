<?php $__env->startSection('title', translate('Too Many Requests', 'errors')); ?>
<?php $__env->startSection('code', '429'); ?>
<?php $__env->startSection('message', translate('Too many requests error message', 'errors')); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/vendor/errors/429.blade.php ENDPATH**/ ?>