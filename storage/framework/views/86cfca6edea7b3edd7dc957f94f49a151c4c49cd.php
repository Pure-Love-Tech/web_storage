<?php $__env->startSection('title', translate('Page Not Found', 'errors')); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('message', translate('Page not found error message', 'errors')); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/vendor/errors/404.blade.php ENDPATH**/ ?>