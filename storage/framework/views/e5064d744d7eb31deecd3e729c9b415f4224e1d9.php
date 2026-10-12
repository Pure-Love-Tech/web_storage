<div class="settings-links mb-4">
    <div class="row row-cols-1 row-cols-sm-auto g-2">
        <div class="col">
            <a href="<?php echo e(route('user.settings.index')); ?>"
                class="settings-link <?php echo e(request()->routeIs('user.settings.index') ? 'active' : ''); ?>">
                <i class="fa fa-user me-1"></i>
                <?php echo e(translate('Account details', 'settings')); ?>

            </a>
        </div>
        <div class="col">
            <a href="<?php echo e(route('user.settings.password')); ?>"
                class="settings-link <?php echo e(request()->routeIs('user.settings.password') ? 'active' : ''); ?>">
                <i class="fa-solid fa-lock me-1"></i>
                <?php echo e(translate('Change Password', 'settings')); ?>

            </a>
        </div>
        <div class="col">
            <a href="<?php echo e(route('user.settings.2fa')); ?>"
                class="settings-link <?php echo e(request()->routeIs('user.settings.2fa') ? 'active' : ''); ?>">
                <i class="fa-solid fa-shield-halved me-1"></i>
                <?php echo e(translate('2FA Authentication', 'settings')); ?>

            </a>
        </div>
        <div class="col">
            <a href="<?php echo e(route('user.settings.withdrawal')); ?>"
                class="settings-link <?php echo e(request()->routeIs('user.settings.withdrawal') ? 'active' : ''); ?>">
                <i class="fa-solid fa-landmark me-1"></i>
                <?php echo e(translate('Withdrawal details', 'settings')); ?>

            </a>
        </div>
        <?php if(licenseType(2)): ?>
            <div class="col">
                <a href="<?php echo e(route('user.settings.subscription')); ?>"
                    class="settings-link <?php echo e(request()->routeIs('user.settings.subscription') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-gem me-1"></i>
                    <?php echo e(translate('Subscription', 'settings')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/settings/includes/links.blade.php ENDPATH**/ ?>