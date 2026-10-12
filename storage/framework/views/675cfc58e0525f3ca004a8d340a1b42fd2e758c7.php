<?php $__env->startSection('title', admin_trans('Reported files')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-3x">#</th>
                    <th class="tb-w-20x"><?php echo e(admin_trans('Reported file')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Reported by')); ?></th>
                    <th class="tb-w-3x"><?php echo e(admin_trans('Reason')); ?></th>
                    <th class="tb-w-7x"><?php echo e(admin_trans('Date')); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $fileReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileReport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="item">
                        <td>
                            <a href="<?php echo e(route('admin.files.reports.show', $fileReport->id)); ?>">
                                #<?php echo e($fileReport->id); ?>

                            </a>
                        </td>
                        <td>
                            <div class="vironeer-content-box">
                                <?php
                                    $fileEntry = $fileReport->file_entry;
                                    $link = route($fileEntry->user_id ? 'admin.files.users.show' : 'admin.files.visitors.show', $fileEntry->id);
                                ?>
                                <a class="vironeer-content-image text-center"
                                    href="<?php echo e(route('admin.files.reports.show', $fileReport->id)); ?>">
                                    <?php echo $fileEntry->getFileIcon(); ?>

                                </a>
                                <div>
                                    <a class="text-reset" href="<?php echo e($link); ?>">
                                        <?php echo e(shortertext($fileEntry->getFullName(), 50)); ?>

                                    </a>
                                    <p class="text-muted mb-0">
                                        <?php echo e(shortertext($fileEntry->mime, 50) ?? admin_trans('Unknown')); ?>

                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="vironeer-content-box">
                                <div>
                                    <span><?php echo e(shortertext($fileReport->name, 30)); ?></span>
                                    <p class="text-muted mb-0"><?php echo e(shortertext($fileReport->email, 30)); ?></p>
                                </div>
                            </div>
                        </td>
                        <td><?php echo e(shortertext(\App\Models\FileReport::reasons()[$fileReport->reason], 25)); ?></td>
                        <td><?php echo e(dateFormat($fileReport->created_at)); ?></td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end dropdown-menu-lg"
                                    data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?php echo e(route('admin.files.reports.show', $fileReport->id)); ?>">
                                            <i class="fa-regular fa-eye"></i>
                                            <?php echo e(admin_trans('View')); ?></a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="<?php echo e(route('admin.files.reports.destroy', $fileReport->id)); ?>"
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
    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/vironeer/vironeer-icons.min.css')); ?>">
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/files/reports/index.blade.php ENDPATH**/ ?>