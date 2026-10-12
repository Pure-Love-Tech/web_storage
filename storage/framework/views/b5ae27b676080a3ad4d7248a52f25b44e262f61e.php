<?php
    $users = \App\Models\User::all();
?>
<select name="user" class="form-select selectpicker" title="<?php echo e(admin_trans('User')); ?>" data-live-search="true">
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($user->id); ?>" <?php echo e(request('user') == $user->id ? 'selected' : ''); ?>>
            <?php echo e($user->id . ' - ' . $user->username . ' (' . $user->email . ')'); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/partials/users-select.blade.php ENDPATH**/ ?>