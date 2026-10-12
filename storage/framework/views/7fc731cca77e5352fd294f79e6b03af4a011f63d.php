<?php $__env->startSection('title', admin_trans('Storage Providers')); ?>
<?php $__env->startSection('section', admin_trans('Settings')); ?>
<?php $__env->startSection('container', 'container-max-lg'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-1x"><?php echo e(admin_trans('#')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Logo')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('name')); ?></th>
                    <th class="tb-w-7x"><?php echo e(admin_trans('Status')); ?></th>
                    <th class="tb-w-7x"><?php echo e(admin_trans('Last Update')); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $storageProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storageProvider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="item">
                        <td><?php echo e($storageProvider->id); ?></td>
                        <td>
                            <?php if(!$storageProvider->isLocal()): ?>
                                <a href="<?php echo e(route('admin.settings.storage.edit', $storageProvider->id)); ?>">
                                    <img src="<?php echo e(asset($storageProvider->logo)); ?>" height="40" width="40">
                                </a>
                            <?php else: ?>
                                <img src="<?php echo e(asset($storageProvider->logo)); ?>" height="40" width="40">
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($storageProvider->isLocal()): ?>
                                <span>
                                    <?php echo e($storageProvider->name); ?>

                                    <?php echo e($storageProvider->isDefault() ? admin_trans('(Default)') : ''); ?>

                                </span>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.settings.storage.edit', $storageProvider->id)); ?>"
                                    class="text-dark">
                                    <?php echo e($storageProvider->name); ?>

                                    <?php echo e($storageProvider->isDefault() ? admin_trans('(Default)') : ''); ?>

                                </a>
                            <?php endif; ?>
                            <?php if(demoMode() && isAddonActive($storageProvider->alias)): ?>
                                <span class="badge bg-c-1 ms-2"><?php echo e(admin_trans('Addon')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($storageProvider->status): ?>
                                <span class="badge bg-success"><?php echo e(admin_trans('Enabled')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e(admin_trans('Disabled')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(dateFormat($storageProvider->updated_at)); ?></td>
                        <td>
                            <?php if(!$storageProvider->isLocal() || !$storageProvider->isDefault()): ?>
                                <div class="text-end">
                                    <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                        <?php if(!$storageProvider->isLocal()): ?>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.settings.storage.edit', $storageProvider->id)); ?>"><i
                                                        class="fa fa-edit me-2"></i><?php echo e(admin_trans('Edit')); ?></a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                        <?php endif; ?>
                                        <?php if(!$storageProvider->isDefault()): ?>
                                            <li>
                                                <form
                                                    action="<?php echo e(route('admin.settings.storage.default', $storageProvider->id)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="vironeer-form-confirm dropdown-item"><i
                                                            class="fas fa-thumbtack me-2"></i><?php echo e(admin_trans('Set As Default')); ?></button>
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/settings/storage/index.blade.php ENDPATH**/ ?>