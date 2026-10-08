<?php $__env->startSection('title', $active . ' | ' . admin_trans('Announcements')); ?>
<?php $__env->startSection('link', route('admin.announcements.create')); ?>
<?php $__env->startSection('language', true); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x"><?php echo e(admin_trans('#')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Language')); ?></th>
                    <th class="tb-w-15x"><?php echo e(admin_trans('Title')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Status')); ?></th>
                    <th class="tb-w-7x"><?php echo e(admin_trans('Published date')); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($announcement->id); ?></td>
                        <td><a href="<?php echo e(route('admin.settings.languages.translates', $announcement->lang)); ?>"><i
                                    class="fas fa-language me-2"></i><?php echo e($announcement->language->name); ?></a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.announcements.edit', $announcement->id)); ?>" class="text-dark"><i
                                    class="fas fa-bullhorn me-2"></i><?php echo e(shortertext($announcement->title, 50)); ?></a>
                        </td>
                        <td>
                            <?php if($announcement->status): ?>
                                <span class="badge bg-success"><?php echo e(admin_trans('Public')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e(admin_trans('Private')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(dateFormat($announcement->created_at)); ?></td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo e(route('admin.announcements.edit', $announcement->id)); ?>"><i
                                                class="fa fa-edit me-2"></i><?php echo e(admin_trans('Edit')); ?></a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="<?php echo e(route('admin.announcements.destroy', $announcement->id)); ?>"
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/announcements/index.blade.php ENDPATH**/ ?>