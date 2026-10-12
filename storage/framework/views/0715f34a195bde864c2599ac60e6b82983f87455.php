<div class="drop-down user-menu ms-3" data-dropdown data-dropdown-position="top">
    <div class="drop-down-btn">
        <img src="<?php echo e(asset(auth()->user()->avatar)); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="user-img">
        <span class="user-name"><?php echo e(auth()->user()->name); ?></span>
        <i class="fa fa-angle-down ms-2"></i>
    </div>
    <div class="drop-down-menu">
        <?php if(!request()->routeIs('verification.verify') && !request()->routeIs('2fa.verify')): ?>
            <a href="<?php echo e(route('user.dashboard')); ?>" class="drop-down-item">
                <i class="fa-solid fa-table-columns"></i>
                <span><?php echo e(translate('Dashboard', 'dashboard')); ?></span>
            </a>
            <a href="<?php echo e(route('user.files.index')); ?>" class="drop-down-item">
                <i class="fa-regular fa-folder-open"></i>
                <span><?php echo e(translate('My Files', 'files')); ?></span>
            </a>
            <a href="<?php echo e(route('user.settings.index')); ?>" class="drop-down-item">
                <i class="fa fa-cog"></i>
                <span><?php echo e(translate('Settings', 'settings')); ?></span>
            </a>
        <?php endif; ?>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="drop-down-item text-danger">
            <i class="fa fa-power-off"></i>
            <span><?php echo e(translate('Logout', 'auth')); ?></span>
        </a>
    </div>
</div>
<form id="logout-form" class="d-inline" action="<?php echo e(route('logout')); ?>" method="POST">
    <?php echo csrf_field(); ?>
</form>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/partials/user-menu.blade.php ENDPATH**/ ?>