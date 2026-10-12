<?php $__env->startSection('title', admin_trans('Visitors files')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-c1">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">
                        <?php echo e(admin_trans('Total files')); ?>

                    </p>
                    <p class="vironeer-counter-card-number"><?php echo e(number_format($counters['total_files'])); ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-gray">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-hard-drive"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">
                        <?php echo e(admin_trans('Used space')); ?>

                    </p>
                    <p class="vironeer-counter-card-number"><?php echo e(formatBytes($counters['used_space'])); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form class="multiple-select-search-form" action="<?php echo e(request()->url()); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control"
                            placeholder="<?php echo e(admin_trans('Search...')); ?>" value="<?php echo e(request('search') ?? ''); ?>">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="shared_id" class="form-control"
                            placeholder="<?php echo e(admin_trans('Shared id')); ?>" value="<?php echo e(request('shared_id') ?? ''); ?>">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col">
                        <a href="<?php echo e(route('admin.files.visitors.index')); ?>"
                            class="btn btn-secondary w-100"><?php echo e(admin_trans('Reset')); ?></a>
                    </div>
                </div>
            </form>
            <form class="multiple-select-delete-form d-none" action="<?php echo e(route('admin.files.visitors.destroy.selected')); ?>"
                method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="delete_ids" class="multiple-select-delete-ids">
                <button class="vironeer-able-to-delete btn btn-danger"><i
                        class="far fa-trash-alt me-2"></i><?php echo e(admin_trans('Delete Selected')); ?></button>
            </form>
        </div>
        <div>
            <?php if($fileEntries->count() > 0): ?>
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th class="tb-w-3x">
                                    <input class="multiple-select-check-all form-check-input" type="checkbox">
                                </th>
                                <th class="tb-w-20x"><?php echo e(admin_trans('File details')); ?></th>
                                <th class="tb-w-2x"><?php echo e(admin_trans('File size')); ?></th>
                                <th class="tb-w-3x text-center"><?php echo e(admin_trans('Downloads')); ?></th>
                                <th class="tb-w-2x text-center"><?php echo e(admin_trans('IP Address')); ?></th>
                                <th class="tb-w-7x text-center"><?php echo e(admin_trans('Storage')); ?></th>
                                <th class="tb-w-3x text-center"><?php echo e(admin_trans('Uploaded Date')); ?></th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $fileEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input class="form-check-input multiple-select-checkbox"
                                            data-id="<?php echo e($fileEntry->id); ?>" type="checkbox">
                                    </td>
                                    <td>
                                        <div class="vironeer-content-box">
                                            <a class="vironeer-content-image text-center"
                                                href="<?php echo e(route('admin.files.visitors.show', $fileEntry->id)); ?>">
                                                <?php echo $fileEntry->getFileIcon(); ?>

                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="<?php echo e(route('admin.files.visitors.show', $fileEntry->id)); ?>"><?php echo e(shortertext($fileEntry->getFullName(), 50)); ?></a>
                                                <p class="text-muted mb-0">
                                                    <?php echo e(shortertext($fileEntry->mime, 50) ?? admin_trans('Unknown')); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($fileEntry->getFullSize()); ?></td>
                                    <td class="text-center"><?php echo e(formatNumber($fileEntry->downloads)); ?></td>
                                    <td class="text-center">
                                        <?php if(!demoMode()): ?>
                                            <?php if($fileEntry->ip): ?>
                                                <a href="<?php echo e(route('admin.members.users.logsbyip', $fileEntry->ip)); ?>"><i
                                                        class="fa-solid fa-location-dot me-2"></i><?php echo e($fileEntry->ip); ?></a>
                                            <?php else: ?>
                                                <span>--</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span><?php echo e(admin_trans('Hidden in demo')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($fileEntry->storageProvider->isLocal()): ?>
                                            <span><i
                                                    class="fas fa-server me-2"></i><?php echo e($fileEntry->storageProvider->alias); ?></span>
                                        <?php else: ?>
                                            <a class="text-dark capitalize"
                                                href="<?php echo e(route('admin.settings.storage.edit', $fileEntry->storageProvider->id)); ?>">
                                                <i class="fas fa-server me-2"></i>
                                                <?php echo e($fileEntry->storageProvider->alias); ?>

                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e(dateFormat($fileEntry->created_at)); ?></td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-md-end dropdown-menu-lg"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item" target="_blank"
                                                        href="<?php echo e($fileEntry->sharedLink()); ?>"><i
                                                            class="fas fa-external-link-alt me-2"></i><?php echo e(admin_trans('Preview')); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.files.visitors.download', [$fileEntry->id, $fileEntry->getFullName()])); ?>"><i
                                                            class="fas fa-download me-2"></i><?php echo e(admin_trans('Download')); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.files.visitors.show', $fileEntry->id)); ?>"><i
                                                            class="fas fa-desktop me-2"></i><?php echo e(admin_trans('File details')); ?></a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="<?php echo e(route('admin.files.visitors.destroy', $fileEntry->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button
                                                            class="vironeer-able-to-delete dropdown-item text-danger"><i
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
            <?php else: ?>
                <?php echo $__env->make('backend.partials.empty', ['class' => 'empty-lg'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php echo e($fileEntries->links()); ?>

    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/vironeer/vironeer-icons.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/files/visitors/index.blade.php ENDPATH**/ ?>