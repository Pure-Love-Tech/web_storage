<?php $__env->startSection('title', admin_trans('Withdrawals')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-orange">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Pending')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e($counters['pending']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-purple">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Returned')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e($counters['returned']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-blue">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-check-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Approved')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e($counters['approved']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Completed')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e($counters['completed']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Cancelled')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e($counters['cancelled']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-c-5">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Pending withdrawal amount')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e(earnings($counters['pending_withdrawal_amount'])); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl">
            <div class="vironeer-counter-card bg-c-4">
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
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="<?php echo e(request()->url()); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="<?php echo e(admin_trans('Search...')); ?>" value="<?php echo e(request('search') ?? ''); ?>">
                    </div>
                    <div class="col-12 col-lg-3">
                        <?php echo $__env->make('backend.partials.users-select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="<?php echo e(admin_trans('Status')); ?>">
                            <option value="1" <?php echo e(request('status') == 1 ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Pending')); ?></option>
                            <option value="2" <?php echo e(request('status') == 2 ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Returned')); ?></option>
                            <option value="3" <?php echo e(request('status') == 3 ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Approved')); ?></option>
                            <option value="4" <?php echo e(request('status') == 4 ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Completed')); ?></option>
                            <option value="5" <?php echo e(request('status') == 5 ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Cancelled')); ?></option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="withdrawal_method" class="form-select selectpicker"
                            title="<?php echo e(admin_trans('Withdrawal Method')); ?>" data-live-search="true">
                            <?php $__currentLoopData = $withdrawalMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawalMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($withdrawalMethod->name); ?>"
                                    <?php echo e(request('withdrawal_method') == $withdrawalMethod->name ? 'selected' : ''); ?>>
                                    <?php echo e($withdrawalMethod->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="<?php echo e(route('admin.withdrawals.index')); ?>"
                            class="btn btn-secondary w-100"><?php echo e(admin_trans('Reset')); ?></a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <?php if($withdrawals->count() > 0): ?>
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th><?php echo e(admin_trans('ID')); ?></th>
                                <th><?php echo e(admin_trans('User')); ?></th>
                                <th><?php echo e(admin_trans('Downloads Earnings')); ?></th>
                                <th><?php echo e(admin_trans('Referrals Earnings')); ?></th>
                                <th><?php echo e(admin_trans('Total Amount')); ?></th>
                                <th><?php echo e(admin_trans('Method')); ?></th>
                                <th class="text-center"><?php echo e(admin_trans('Status')); ?></th>
                                <th class="text-center"><?php echo e(admin_trans('Withdrawal Date')); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('admin.withdrawals.edit', $withdrawal->id)); ?>"><i
                                                class="fa-solid fa-money-check-dollar me-1"></i>#<?php echo e($withdrawal->id); ?></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.members.users.edit', $withdrawal->user->id)); ?>"
                                            class="text-dark"><i
                                                class="fa fa-user me-2"></i><?php echo e($withdrawal->user->username); ?></a>
                                    </td>
                                    <td><strong><?php echo e(earnings($withdrawal->downloads_earnings)); ?></strong></td>
                                    <td><strong><?php echo e(earnings($withdrawal->referrals_earnings)); ?></strong></td>
                                    <td class="text-success"><strong><?php echo e(earnings($withdrawal->total)); ?></strong>
                                    </td>
                                    <td><?php echo e($withdrawal->method); ?></td>
                                    <td class="text-center">
                                        <?php if($withdrawal->isPending()): ?>
                                            <div class="badge rounded-pill bg-orange">
                                                <?php echo e(admin_trans('Pending')); ?>

                                            </div>
                                        <?php elseif($withdrawal->isReturned()): ?>
                                            <div class="badge rounded-pill bg-purple">
                                                <?php echo e(admin_trans('Returned')); ?>

                                            </div>
                                        <?php elseif($withdrawal->isApproved()): ?>
                                            <div class="badge rounded-pill bg-blue">
                                                <?php echo e(admin_trans('Approved')); ?>

                                            </div>
                                        <?php elseif($withdrawal->isCompleted()): ?>
                                            <div class="badge rounded-pill bg-green">
                                                <?php echo e(admin_trans('Completed')); ?>

                                            </div>
                                        <?php elseif($withdrawal->isCancelled()): ?>
                                            <div class="badge rounded-pill bg-red">
                                                <?php echo e(admin_trans('Cancelled')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e(dateFormat($withdrawal->created_at)); ?></td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.withdrawals.edit', $withdrawal->id)); ?>"><i
                                                            class="fa-regular fa-pen-to-square me-2"></i><?php echo e(admin_trans('Edit')); ?></a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="<?php echo e(route('admin.withdrawals.destroy', $withdrawal->id)); ?>"
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
    <?php echo e($withdrawals->links()); ?>

    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/withdrawals/index.blade.php ENDPATH**/ ?>