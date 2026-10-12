<?php $__env->startSection('title', admin_trans('Admins')); ?>
<?php $__env->startSection('section', admin_trans('Settings')); ?>
<?php $__env->startSection('link', route('admin.members.admins.create')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div>
            <table id="datatable" class="table w-100">
                <thead>
                    <tr>
                        <th class="tb-w-2x"><?php echo e(admin_trans('#')); ?></th>
                        <th class="tb-w-20x"><?php echo e(admin_trans('Details')); ?></th>
                        <th class="tb-w-3x"><?php echo e(admin_trans('Added date')); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($admin->id); ?></td>
                            <td>
                                <div class="vironeer-user-box">
                                    <a class="vironeer-user-avatar"
                                        href="<?php echo e(route('admin.members.admins.edit', $admin->id)); ?>">
                                        <img class="rounded-circle" src="<?php echo e(asset($admin->avatar)); ?>" />
                                    </a>
                                    <div>
                                        <a class="text-reset"
                                            href="<?php echo e(route('admin.members.admins.edit', $admin->id)); ?>"><?php echo e($admin->firstname . ' ' . $admin->lastname); ?></a>
                                        <p class="text-muted mb-0"><?php echo e($admin->email); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e(dateFormat($admin->created_at)); ?></td>
                            <td>
                                <div class="text-end">
                                    <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('admin.members.admins.edit', $admin->id)); ?>"><i
                                                    class="fa fa-edit me-2"></i><?php echo e(admin_trans('Edit')); ?></a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <form action="<?php echo e(route('admin.members.admins.destroy', $admin->id)); ?>"
                                                method="POST">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                        class="far fa-trash-alt me-2"></i><?php echo e(admin_trans('Delete')); ?></button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/members/admins/index.blade.php ENDPATH**/ ?>