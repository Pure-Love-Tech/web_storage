<?php $__env->startSection('section', admin_trans('Earnings')); ?>
<?php $__env->startSection('title', admin_trans('Earnings Records')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <?php if(count($dates) > 0): ?>
        <div class="card mb-4">
            <div class="card-header p-3 border-bottom-small">
                <form action="<?php echo e(request()->url()); ?>" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg-5">
                            <select name="period" class="form-select selectpicker" title="<?php echo e(admin_trans('Period')); ?>">
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($date->row); ?>"
                                        <?php echo e(request('period') == $date->row ? 'selected' : ''); ?>>
                                        <?php echo e($date->format); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg-3">
                            <?php echo $__env->make('backend.partials.users-select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-12 col-lg-2">
                            <select name="source" class="form-select selectpicker" title="<?php echo e(admin_trans('Source')); ?>"
                                data-live-search="true">
                                <option value="download"><?php echo e(admin_trans('Download')); ?></option>
                                <option value="referral"><?php echo e(admin_trans('Referral')); ?></option>
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="<?php echo e(route('admin.earnings.records.index')); ?>"
                                class="btn btn-secondary w-100"><?php echo e(admin_trans('Reset')); ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th><?php echo e(admin_trans('ID')); ?></th>
                                <th><?php echo e(admin_trans('User')); ?></th>
                                <th><?php echo e(admin_trans('IP Address')); ?></th>
                                <th><?php echo e(admin_trans('Country')); ?></th>
                                <th><?php echo e(admin_trans('Payout Rate')); ?></th>
                                <th><?php echo e(admin_trans('Earnings')); ?></th>
                                <th class="text-center"><?php echo e(admin_trans('Source')); ?></th>
                                <th class="text-center"><?php echo e(admin_trans('Referer domain')); ?></th>
                                <th class="text-center"><?php echo e(admin_trans('Status')); ?></th>
                                <th class="text-center"><?php echo e(admin_trans('Status Reason')); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a
                                            href="<?php echo e(route('admin.earnings.records.show', $record->id)); ?>">#<?php echo e($record->id); ?></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.members.users.edit', $record->user->id)); ?>"
                                            class="text-dark"><i
                                                class="fa fa-user me-2"></i><?php echo e($record->user->username); ?></a>
                                    </td>
                                    <td>
                                        <?php if(!demoMode()): ?>
                                            <?php if($record->ip): ?>
                                                <a href="<?php echo e(route('admin.members.users.logsbyip', $record->ip)); ?>"><i
                                                        class="fa-solid fa-location-dot me-2"></i><?php echo e(shorterText($record->ip, 20)); ?></a>
                                            <?php else: ?>
                                                <span>--</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span><?php echo e(admin_trans('Hidden in demo')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($record->country ?? '--'); ?></td>
                                    <td><?php echo e($record->payout_rate ? priceSymbol($record->payout_rate) : '--'); ?></td>
                                    <td>
                                        <strong
                                            class="<?php echo e($record->earnings > 0 ? 'text-success' : 'text-dark'); ?>"><?php echo e(earnings($record->earnings)); ?></strong>
                                    </td>
                                    <td class="text-center"><?php echo e(ucfirst($record->earning_source)); ?></td>
                                    <td class="text-center"><?php echo e($record->referer_domain ?? '--'); ?></td>
                                    <td class="text-center">
                                        <?php if($record->isValid()): ?>
                                            <span class="badge bg-green"><?php echo e(admin_trans('Valid')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?php echo e(admin_trans('Invalid')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e($record->status_reason ?? '--'); ?></td>
                                    <td class="text-end">
                                        <a href="<?php echo e(route('admin.earnings.records.show', $record->id)); ?>"
                                            class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php echo e($records->links()); ?>

        <?php $__env->startPush('styles_libs'); ?>
            <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.css')); ?>">
        <?php $__env->stopPush(); ?>
        <?php $__env->startPush('scripts_libs'); ?>
            <script src="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php else: ?>
        <?php echo $__env->make('backend.partials.empty', ['class' => 'empty-lg'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/earnings/records/index.blade.php ENDPATH**/ ?>