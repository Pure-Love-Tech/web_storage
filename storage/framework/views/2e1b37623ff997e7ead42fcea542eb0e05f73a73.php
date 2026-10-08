<div class="nav-bar v2">
    <div class="container-fluid">
        <div class="nav-bar-container">
            <div class="dash-sidebar-btn">
                <i class="fa fa-bars"></i>
            </div>
            <a href="<?php echo e(route('home')); ?>" class="logo">
                <img src="<?php echo e(asset($themeSettings->general->logo_light)); ?>" alt="<?php echo e($settings->general->site_name); ?>" />
            </a>
            <div class="nav-bar-menu">
                <div class="overlay"></div>
                <div class="nav-bar-links">
                    <div class="nav-bar-menu-header">
                        <a class="nav-bar-menu-close ms-auto">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <?php echo $__env->make('themes.basic.partials.language-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="nav-bar-actions">
                <div class="drop-down drop-down-lg ms-3 me-2" data-dropdown data-dropdown-position="top">
                    <div class="drop-down-btn nav-btn announcements-menu-btn" data-id="1">
                        <i class="fa-solid fa-bullhorn"></i>
                        <div class="announcements-menu-counter"><?php echo e($countAnnouncements); ?></div>
                    </div>
                    <div class="drop-down-menu">
                        <div class="announcements-menu">
                            <div class="announcements-menu-header">
                                <h6 class="mb-0"><?php echo e(translate('Announcements', 'announcements')); ?></h6>
                            </div>
                            <div class="announcements-menu-body" data-simplebar>
                                <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="d-flex flex-column">
                                        <div class="announcements-menu-item">
                                            <div class="announcements-menu-item-icon">
                                                <i class="fa fa-bullhorn"></i>
                                            </div>
                                            <div class="announcements-menu-item-info">
                                                <p class="announcements-menu-item-text mb-0"><?php echo e($announcement->title); ?>

                                                </p>
                                                <span
                                                    class="announcements-menu-item-time"><?php echo e($announcement->created_at->diffforhumans()); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center py-5">
                                        <span
                                            class="text-muted"><?php echo e(translate('No Announcements Available', 'announcements')); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="announcements-menu-footer">
                                <a href="<?php echo e(route('user.announcements')); ?>">
                                    <?php echo e(translate('See all announcements', 'announcements')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('themes.basic.partials.user-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="nav-bar-menu-btn">
                    <i class="fa-solid fa-bars-staggered fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/includes/navbar.blade.php ENDPATH**/ ?>