<script type="text/javascript">
    "use strict";
    const config = <?php echo json_encode([
        'url' => adminUrl(),
        'colors' => $settings->system->colors,
    ]); ?>

</script>
<?php echo $__env->yieldPushContent('top_scripts'); ?>
<script src="<?php echo e(asset('vendor/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/sweetalert/sweetalert2.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts_libs'); ?>
<script src="<?php echo e(asset('vendor/libs/toggle-master/bootstrap-toggle.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/datatable/datatables.jq.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/datatable/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/select2/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/backend/js/application.js')); ?>"></script>
<?php echo app('toastr')->render(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/includes/scripts.blade.php ENDPATH**/ ?>