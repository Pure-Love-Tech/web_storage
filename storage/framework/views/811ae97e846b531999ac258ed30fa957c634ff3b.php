<?php $__env->startSection('section', admin_trans('Earnings')); ?>
<?php $__env->startSection('title', admin_trans('Earnings Statistics')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <?php if(count($dates) > 0): ?>
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mb-4">
            <div class="col">
                <div class="vironeer-counter-card bg-secondary">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Downloads')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(number_format($counters['downloads'])); ?></p>
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
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Downloads earnings')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(earnings($counters['downloads_earnings'])); ?></p>
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
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Referral earnings')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(earnings($counters['referrals_earnings'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header p-3 border-bottom-small">
                <form action="<?php echo e(request()->url()); ?>" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg-5">
                            <div class="select-group">
                                <div class="select-group-icon">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                                <select name="period" class="form-select radius">
                                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($date->row); ?>"
                                            <?php echo e(request('period') == $date->row ? 'selected' : ''); ?>>
                                            <?php echo e($date->format); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            <?php echo $__env->make('backend.partials.users-select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="<?php echo e(route('admin.earnings.statistics.index')); ?>"
                                class="btn btn-secondary w-100"><?php echo e(admin_trans('Reset')); ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="vironeer-box chart-bar mb-3">
                <div class="vironeer-box-header">
                    <p class="vironeer-box-header-title large">
                        <?php echo e(admin_trans('Statistics')); ?>

                    </p>
                </div>
                <div class="vironeer-box-body">
                    <div class="chart-bar">
                        <canvas height="400" id="earnings-statistics-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="table-responsive border-top">
                <table class="vironeer-normal-table table table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th><?php echo e(admin_trans('Date')); ?></th>
                            <th><?php echo e(admin_trans('Downloads')); ?></th>
                            <th><?php echo e(admin_trans('Downloads Earnings')); ?></th>
                            <th><?php echo e(admin_trans('Daily CPM')); ?></th>
                            <th><?php echo e(admin_trans('Referrals Earnings')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tableData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key); ?></td>
                                <td><?php echo e(number_format($data['downloads'])); ?></td>
                                <td><?php echo e(earnings($data['download_earnings'])); ?></td>
                                <td><?php echo e(earnings($data['cpm'])); ?></td>
                                <td><?php echo e(earnings($data['referral_earnings'])); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php $__env->startPush('top_scripts'); ?>
            <script>
                "use strict";
                const chartsConfig = <?php echo json_encode([
                    'earnings' => [
                        'title' => admin_trans('Downloads'),
                        'labels' => $chart['labels'],
                        'data' => $chart['data'],
                        'max' => $chart['max'],
                    ],
                ]); ?>;
            </script>
        <?php $__env->stopPush(); ?>
        <?php $__env->startPush('styles_libs'); ?>
            <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.css')); ?>">
        <?php $__env->stopPush(); ?>
        <?php $__env->startPush('scripts_libs'); ?>
            <script src="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendor/libs/chartjs/chart.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendor/backend/js/charts.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php else: ?>
        <?php echo $__env->make('backend.partials.empty', ['class' => 'empty-lg'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/earnings/statistics.blade.php ENDPATH**/ ?>