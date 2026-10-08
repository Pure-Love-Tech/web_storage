<?php $__env->startSection('section', admin_trans('Earnings')); ?>
<?php $__env->startSection('title', admin_trans('Earnings Reports')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card mb-4">
        <div class="card-body p-4">
            <form action="<?php echo e(request()->url()); ?>" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label"><?php echo e(admin_trans('From')); ?></label>
                            </div>
                            <div class="col">
                                <input type="date" name="date_from" class="form-control"
                                    value="<?php echo e(request('date_from')); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label"><?php echo e(admin_trans('To')); ?></label>
                            </div>
                            <div class="col">
                                <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label"><?php echo e(admin_trans('User')); ?></label>
                            </div>
                            <div class="col">
                                <?php echo $__env->make('backend.partials.users-select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="<?php echo e(route('admin.earnings.reports.index')); ?>"
                            class="btn btn-secondary w-100"><?php echo e(admin_trans('Reset')); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if(!$empty): ?>
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 g-3 mb-4">
            <div class="col">
                <div class="vironeer-counter-card bg-secondary">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Total Downloads')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(formatNumber($counters['total_downloads'])); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-green">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Total Downloads earnings')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(earnings($counters['total_downloads_earnings'])); ?>

                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-primary">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Total Referral earnings')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(earnings($counters['total_referrals_earnings'])); ?>

                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-c12">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Total Withdrawn Amount')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(earnings($counters['total_withdrawn_amount'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white border-bottom-0">
                <i class="fa-solid fa-earth-americas me-1"></i>
                <?php echo e(admin_trans('Countries')); ?>

            </div>
            <div class="card-body p-4">
                <div class="row alig-items-center g-4">
                    <div class="col-lg-12 col-xxl-8">
                        <div class="p-4">
                            <div id="countries-downloads-statistics" class="w-100"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xxl-4">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr class="text-start bg-light">
                                    <th><?php echo e(admin_trans('Country')); ?></th>
                                    <th><?php echo e(admin_trans('Downloads')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="text-muted text-start">
                                <?php $__empty_1 = true; $__currentLoopData = $tableCountriesDownloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableCountryDownload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($tableCountryDownload->country); ?></td>
                                        <td><?php echo e($tableCountryDownload->downloads); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2">
                                            <div class="py-2 text-center"><?php echo e(admin_trans('No data found')); ?></div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-secondary text-white border-bottom-0">
                <i class="fa-regular fa-folder-open me-1"></i>
                <?php echo e(admin_trans('Files')); ?>

            </div>
            <div class="table-responsive">
                <table class="vironeer-normal-table table w-100">
                    <thead>
                        <tr>
                            <th><?php echo e(admin_trans('File name')); ?></th>
                            <th class="text-center"><?php echo e(admin_trans('Downloads')); ?></th>
                            <th class="text-center"><?php echo e(admin_trans('Earnings')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $filesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php if($data->file_entry): ?>
                                        <a
                                            href="<?php echo e(route('admin.files.users.show', $data->file_entry->id)); ?>"><?php echo e($data->file_entry->getFullName()); ?></a>
                                    <?php else: ?>
                                        <span><?php echo e($data->file_entry_details->name); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e(number_format($data->total_downloads)); ?></td>
                                <td class="text-center"><?php echo e(earnings($data->total_earnings)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3">
                                    <div class="py-2 text-center"><?php echo e(admin_trans('No data found')); ?></div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo e($filesData->links()); ?>

        <?php $__env->startPush('top_scripts'); ?>
            <?php
                $chartConfig[] = ['Country', admin_trans('Downloads')];
                if (!$geoCountriesDownloads->isEmpty()) {
                    foreach ($geoCountriesDownloads as $geoCountryDownload) {
                        $chartConfig[] = [$geoCountryDownload->country, intval($geoCountryDownload->downloads)];
                    }
                }
            ?>
            <script>
                "use strict";
                const geoChartConfig = <?php echo json_encode($chartConfig, 15, 512) ?>;
            </script>
        <?php $__env->stopPush(); ?>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <?php echo $__env->make('backend.partials.empty', ['class' => 'empty-lg'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.js')); ?>"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="<?php echo e(asset('vendor/backend/js/charts.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/earnings/reports.blade.php ENDPATH**/ ?>