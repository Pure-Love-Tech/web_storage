<?php $__env->startSection('title', admin_trans('Users')); ?>
<?php $__env->startSection('link', route('admin.members.users.create')); ?>
<?php $__env->startSection('container', 'container-max-xxl'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row row-cols-1 row-cols-lg-2 <?php echo e(licenseType(2) ? 'row-cols-xxl-4' : 'row-cols-xxl-2'); ?> g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Active')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e(number_format($counters['active'])); ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Banned')); ?></p>
                    <p class="vironeer-counter-card-number"><?php echo e(number_format($counters['banned'])); ?></p>
                </div>
            </div>
        </div>
        <?php if(licenseType(2)): ?>
            <div class="col">
                <div class="vironeer-counter-card bg-purple">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Subscribed')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(number_format($counters['subscribed'])); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-gray">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-user-minus"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title"><?php echo e(admin_trans('Unsubscribed')); ?></p>
                        <p class="vironeer-counter-card-number"><?php echo e(number_format($counters['unsubscribed'])); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form class="multiple-select-search-form" action="<?php echo e(request()->url()); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-12 <?php echo e(licenseType(2) ? 'col-lg-6' : 'col-lg-8'); ?>">
                        <input type="text" name="search" class="form-control"
                            placeholder="<?php echo e(admin_trans('Search...')); ?>" value="<?php echo e(request()->input('search') ?? ''); ?>">
                    </div>
                    <?php if(licenseType(2)): ?>
                        <div class="col-12 col-lg-2">
                            <select name="subscription" class="form-select selectpicker"
                                title="<?php echo e(admin_trans('Subscription')); ?>">
                                <option value="1" <?php echo e(request('subscription') == '1' ? 'selected' : ''); ?>>
                                    <?php echo e(admin_trans('Subscribed')); ?>

                                </option>
                                <option value="0" <?php echo e(request('subscription') == '0' ? 'selected' : ''); ?>>
                                    <?php echo e(admin_trans('Unsubscribed')); ?></option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="<?php echo e(admin_trans('Status')); ?>">
                            <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Active')); ?>

                            </option>
                            <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>
                                <?php echo e(admin_trans('Banned')); ?></option>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="<?php echo e(route('admin.members.users.index')); ?>"
                            class="btn btn-secondary w-100"><?php echo e(admin_trans('Reset')); ?></a>
                    </div>
                </div>
            </form>
            <form class="multiple-select-delete-form d-none" action="<?php echo e(route('admin.members.users.destroy.selected')); ?>"
                method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="delete_ids" class="multiple-select-delete-ids">
                <button class="vironeer-able-to-delete btn btn-danger"><i
                        class="far fa-trash-alt me-2"></i><?php echo e(admin_trans('Delete Selected')); ?></button>
            </form>
        </div>
        <div>
            <?php if($users->count() > 0): ?>
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th class="tb-w-3x">
                                    <input class="multiple-select-check-all form-check-input" type="checkbox">
                                </th>
                                <th class="tb-w-3x"><?php echo e(admin_trans('ID')); ?></th>
                                <th class="tb-w-20x"><?php echo e(admin_trans('User details')); ?></th>
                                <th class="tb-w-3x text-center"><?php echo e(admin_trans('Referred by')); ?></th>
                                <?php if(licenseType(2)): ?>
                                    <th class="tb-w-3x text-center"><?php echo e(admin_trans('Subscription')); ?></th>
                                <?php endif; ?>
                                <th class="tb-w-2x text-center"><?php echo e(admin_trans('Email status')); ?></th>
                                <th class="tb-w-2x text-center"><?php echo e(admin_trans('Account status')); ?></th>
                                <th class="tb-w-3x text-center"><?php echo e(admin_trans('Registred date')); ?></th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input class="form-check-input multiple-select-checkbox"
                                            data-id="<?php echo e($user->id); ?>" type="checkbox">
                                    </td>
                                    <td><?php echo e($user->id); ?></td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="<?php echo e(route('admin.members.users.edit', $user->id)); ?>">
                                                <img src="<?php echo e(asset($user->avatar)); ?>" alt="User" />
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="<?php echo e(route('admin.members.users.edit', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                <p class="text-muted mb-0"><?php echo e($user->email); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($user->referrer): ?>
                                            <a href="<?php echo e(route('admin.members.users.edit', $user->referrer->referring_user->id)); ?>"
                                                class="text-dark"><i
                                                    class="fa fa-user me-2"></i><?php echo e($user->referrer->referring_user->username); ?></a>
                                        <?php else: ?>
                                            <span>--</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(licenseType(2)): ?>
                                        <td class="text-center">
                                            <?php if($user->isSubscribed()): ?>
                                                <span class="badge bg-purple"><?php echo e(admin_trans('Subscribed')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-gray"><?php echo e(admin_trans('Unsubscribed')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <?php if($user->email_verified_at): ?>
                                            <span class="badge bg-blue"><?php echo e(admin_trans('Verified')); ?></span>
                                        <?php else: ?>
                                            <span
                                                class="badge bg-warning text-dark"><?php echo e(admin_trans('Unverified')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($user->status): ?>
                                            <span class="badge bg-green"><?php echo e(admin_trans('Active')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-red"><?php echo e(admin_trans('Banned')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e(dateFormat($user->created_at)); ?></td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button"
                                                        id="earningsDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-dollar-sign"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="earningsDropdown">
                                                        <?php if(licenseType(2)): ?>
                                                            <?php if($user->isSubscribed()): ?>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="<?php echo e(route('admin.premium.subscriptions.edit', $user->subscription->id)); ?>">
                                                                        <i class="fas fa-gem me-1"></i>
                                                                        <?php echo e(admin_trans('Subscription')); ?>

                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="<?php echo e(route('admin.premium.transactions.index', 'user=' . $user->id)); ?>">
                                                                    <i class="fa-solid fa-file-invoice me-1"></i>
                                                                    <?php echo e(admin_trans('Transactions')); ?>

                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.withdrawals.index', 'user=' . $user->id)); ?>">
                                                                <i class="fa-regular fa-paper-plane me-1"></i>
                                                                <?php echo e(admin_trans('Withdrawals')); ?>

                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.earnings.statistics.index', 'user=' . $user->id)); ?>">
                                                                <i class="fa-solid fa-chart-simple me-1"></i>
                                                                <?php echo e(admin_trans('Earnings Stats')); ?>

                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.earnings.records.index', 'user=' . $user->id)); ?>">
                                                                <i class="fa-solid fa-arrows-rotate me-1"></i>
                                                                <?php echo e(admin_trans('Earnings Records')); ?>

                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="settingsDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-list"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.members.users.edit', $user->id)); ?>">
                                                                <i class="fas fa-edit me-1"></i>
                                                                <?php echo e(admin_trans('Edit details')); ?>

                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.files.users.index', 'user=' . $user->id)); ?>">
                                                                <i class="fa-solid fa-upload me-1"></i>
                                                                <?php echo e(admin_trans('Uploads')); ?>

                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.members.users.referrals.index', $user->id)); ?>">
                                                                <i class="fas fa-users me-1"></i>
                                                                <?php echo e(admin_trans('Referrals')); ?>

                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('admin.members.users.logs', $user->id)); ?>">
                                                                <i class="fas fa-list-ul me-1"></i>
                                                                <?php echo e(admin_trans('Login logs')); ?>

                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider" />
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="<?php echo e(route('admin.members.users.destroy', $user->id)); ?>"
                                                                method="POST">
                                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                                <button
                                                                    class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                                        class="far fa-trash-alt me-2"></i><?php echo e(admin_trans('Delete')); ?></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
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
    <?php echo e($users->links()); ?>

    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/bootstrap/select/bootstrap-select.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/members/users/index.blade.php ENDPATH**/ ?>