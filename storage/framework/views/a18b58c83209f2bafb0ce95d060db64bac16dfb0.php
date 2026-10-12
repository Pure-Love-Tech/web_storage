<aside class="dash-sidebar">
    <div class="overlay"></div>
    <div class="dash-sidebar-content">
        <div class="dash-sidebar-body">
            <div class="dash-balance flex-shrink-0">
                <div class="dash-balance-info">
                    <p class="dash-balance-title"><?php echo e(translate('Balance', 'sidebar')); ?></p>
                    <p class="dash-balance-number mb-0"><?php echo e(earnings(auth()->user()->balance())); ?></p>
                </div>
                <div class="dash-balance-icon">
                    <i class="fa fa-wallet"></i>
                </div>
            </div>
            <div class="dash-sidebar-links flex-shrink-0">
                <div class="dash-sidebar-links-body">
                    <a href="javascript:void(0)" class="dash-sidebar-link" data-upload-btn>
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span><?php echo e(translate('Upload Files', 'sidebar')); ?></span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('user.dashboard')); ?>"
                        class="dash-sidebar-link <?php echo e(request()->routeIs('user.dashboard') ? 'current' : ''); ?>">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-table-columns"></i>
                            <span><?php echo e(translate('Dashboard', 'dashboard')); ?></span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('user.files.index')); ?>"
                        class="dash-sidebar-link <?php echo e(request()->routeIs('user.files.*') ? 'current' : ''); ?>">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-folder-open"></i>
                            <span><?php echo e(translate('My Files', 'files')); ?></span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('user.withdrawals.index')); ?>"
                        class="dash-sidebar-link <?php echo e(request()->routeIs('user.withdrawals.index') ? 'current' : ''); ?>">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                            <span><?php echo e(translate('Withdrawals', 'withdrawals')); ?></span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('user.referrals')); ?>"
                        class="dash-sidebar-link <?php echo e(request()->routeIs('user.referrals') ? 'current' : ''); ?>">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-users"></i>
                            <span><?php echo e(translate('Referrals', 'referrals')); ?></span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('user.settings.index')); ?>"
                        class="dash-sidebar-link <?php echo e(request()->routeIs('user.settings.*') ? 'current' : ''); ?>">
                        <div class="dash-sidebar-link-title">
                            <i class="fa fa-cog"></i>
                            <span><?php echo e(translate('Settings', 'settings')); ?></span>
                        </div>
                    </a>
                    <a href="#" class="dash-sidebar-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="dash-sidebar-link-title">
                            <i class="fas fa-power-off"></i>
                            <span><?php echo e(translate('Logout', 'auth')); ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="upgrade mt-auto flex-shrink-0">
                <h6 class="upgrade-title"><?php echo e(translate('Storage', 'sidebar')); ?></h6>
                <?php if(subscription()->plan->storage_space): ?>
                    <div class="progress mb-2">
                        <div class="progress-bar <?php echo e(subscription()->storage->fullness >= 80 && subscription()->storage->fullness < 99 ? 'bg-warning' : (subscription()->storage->fullness == 100 ? 'bg-danger' : 'bg-secondary')); ?>"
                            role="progressbar" style="width: <?php echo e(subscription()->storage->fullness); ?>%"
                            aria-valuenow="<?php echo e(subscription()->storage->fullness); ?>" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row g-3 row-cols-auto align-items-center justify-content-between">
                    <div class="col">
                        <h6 class="text-end mb-0 small">
                            <?php echo str_replace(
                                ['{used_space}', '{storage_space}'],
                                [subscription()->storage->used->formatted, subscription()->formats->storage_space],
                                translate('{used_space} of {storage_space}', 'sidebar'),
                            ); ?>

                        </h6>
                    </div>
                    <div class="col-12">
                        <?php if(licenseType(2)): ?>
                            <?php if(subscription()->is_premium): ?>
                                <?php if(subscription()->is_expired): ?>
                                    <a href="<?php echo e(route('premium.index')); ?>"
                                        class="btn btn-outline-secondary radius radius-md w-100">
                                        <i class="fa-solid fa-rotate me-1"></i>
                                        <?php echo e(translate('Renew', 'sidebar')); ?>

                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-primary radius radius-md w-100" data-upload-btn>
                                        <i class="fa fa-upload me-1"></i>
                                        <?php echo e(translate('Upload files', 'sidebar')); ?>

                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('premium.index')); ?>" class="btn btn-primary radius radius-md w-100">
                                    <i class="fa fa-gem me-1"></i>
                                    <?php echo e(translate('Upgrade', 'sidebar')); ?>

                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-primary radius radius-md w-100" data-upload-btn>
                                <i class="fa fa-upload me-1"></i>
                                <?php echo e(translate('Upload files', 'sidebar')); ?>

                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/includes/sidebar.blade.php ENDPATH**/ ?>