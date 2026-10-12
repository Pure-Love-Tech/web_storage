<?php $__env->startSection('section', admin_trans('Settings')); ?>
<?php $__env->startSection('title', admin_trans('Plans')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-7x"><?php echo e(admin_trans('Name')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Storage space')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Max File size')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('File expiration')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Download waiting time')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Upload status')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Last Update')); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('admin.plans.edit', $plan->id)); ?>">
                                <?php if($plan->isForVisitors()): ?>
                                    <i class="fa-solid fa-eye fa-lg me-2"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-users fa-lg me-2"></i>
                                <?php endif; ?>
                                <span><?php echo e($plan->name); ?></span>
                            </a>
                        </td>
                        <td><?php echo e($plan->storageSpaceFormatted()); ?></td>
                        <td><?php echo e($plan->maxFileSizeFormatted()); ?></td>
                        <td><?php echo e($plan->fileExpiryDaysFormatted()); ?></td>
                        <td><?php echo e($plan->downloadWaitingTimeFormatted()); ?></td>
                        <td>
                            <?php if($plan->upload_status): ?>
                                <span class="badge bg-green"><?php echo e(admin_trans('Active')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e(admin_trans('Disabled')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(dateFormat($plan->updated_at)); ?></td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.plans.edit', $plan->id)); ?>"><i
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

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/plans/index.blade.php ENDPATH**/ ?>