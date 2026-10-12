<?php $__env->startSection('title', admin_trans('advertisements')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card ratings">
        <table class="table unsort-datatable w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">#</th>
                    <th class="tb-w-7x"><?php echo e(admin_trans('Position')); ?></th>
                    <th class="tb-w-5x"><?php echo e(admin_trans('Size')); ?></th>
                    <th class="tb-w-5x"><?php echo e(admin_trans('Status')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Last update')); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $advertisements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advertisement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($advertisement->id); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.advertisements.edit', $advertisement->id)); ?>" class="text-dark">
                                <i class="fas fa-ad me-2"></i><?php echo e($advertisement->position); ?>

                            </a>
                        </td>
                        <td><?php echo e($advertisement->size ?? '--'); ?></td>
                        <td>
                            <?php if($advertisement->status): ?>
                                <span class="badge bg-success"><?php echo e(admin_trans('Active')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e(admin_trans('Disabled')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(dateFormat($advertisement->updated_at)); ?></td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo e(route('admin.advertisements.edit', $advertisement->id)); ?>"><i
                                                class="fa fa-edit me-2"></i><?php echo e(admin_trans('Edit')); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/advertisements/index.blade.php ENDPATH**/ ?>