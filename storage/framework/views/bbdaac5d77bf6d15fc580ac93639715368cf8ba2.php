<header class="vironeer-page-header">
    <div class="vironeer-sibebar-icon me-auto">
        <i class="fa fa-bars fa-lg"></i>
    </div>
    <div class="button">
        <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-outline-dark rounded-50"><i
                class="fa fa-eye me-2"></i><?php echo e(admin_trans('Preview')); ?></a>
    </div>
    <div class="vironeer-notifications ms-2" data-dropdown-v2>
        <div class="vironeer-notifications-title">
            <i class="far fa-bell"></i>
            <div class="counter"><?php echo e($unreadAdminNotifications); ?></div>
        </div>
        <div class="vironeer-notifications-menu">
            <div class="vironeer-notifications-header">
                <p class="vironeer-notifications-header-title mb-0">
                    <?php echo e(admin_trans('Notifications')); ?> (<?php echo e($unreadAdminNotificationsAll); ?>)</p>
                <?php if($unreadAdminNotifications): ?>
                    <a href="<?php echo e(route('admin.notifications.readall')); ?>"
                        class="ms-auto vironeer-link-confirm"><?php echo e(admin_trans('Mark All as Read')); ?></a>
                <?php else: ?>
                    <span class="ms-auto text-muted"><?php echo e(admin_trans('Mark All as Read')); ?></span>
                <?php endif; ?>
            </div>
            <div class="vironeer-notifications-body">
                <?php $__empty_1 = true; $__currentLoopData = $adminNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adminNotification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if($adminNotification->link): ?>
                        <a class="vironeer-notification"
                            href="<?php echo e(route('admin.notifications.show', $adminNotification->id)); ?>">
                            <div class="vironeer-notification-image">
                                <img src="<?php echo e($adminNotification->image); ?>" alt="<?php echo e($adminNotification->title); ?>">
                            </div>
                            <div class="vironeer-notification-info">
                                <p
                                    class="vironeer-notification-title mb-0 d-flex justify-content-between align-items-center">
                                    <span><?php echo e(shortertext($adminNotification->title, 30)); ?></span>
                                    <?php if(!$adminNotification->status): ?>
                                        <span class="unread flashit"><i class="fas fa-circle"></i></span>
                                    <?php endif; ?>
                                </p>
                                <p class="vironeer-notification-text mb-0">
                                    <?php echo e($adminNotification->created_at->diffforhumans()); ?>

                                </p>
                            </div>
                        </a>
                    <?php else: ?>
                        <div class="vironeer-notification">
                            <div class="vironeer-notification-image">
                                <img src="<?php echo e($adminNotification->image); ?>" alt="<?php echo e($adminNotification->title); ?>">
                            </div>
                            <div class="vironeer-notification-info">
                                <p
                                    class="vironeer-notification-title mb-0 d-flex justify-content-between align-items-center">
                                    <span><?php echo e(shortertext($adminNotification->title, 30)); ?></span>
                                    <?php if(!$adminNotification->status): ?>
                                        <span class="unread flashit"><i class="fas fa-circle"></i></span>
                                    <?php endif; ?>
                                </p>
                                <p class="vironeer-notification-text mb-0">
                                    <?php echo e($adminNotification->created_at->diffforhumans()); ?>

                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty">
                        <small class="text-muted mb-0"><?php echo e(admin_trans('No notifications found')); ?></small>
                    </div>
                <?php endif; ?>
            </div>
            <a class="vironeer-notifications-footer" href="<?php echo e(route('admin.notifications.index')); ?>">
                <?php echo e(admin_trans('View All')); ?>

            </a>
        </div>
    </div>

    <div class="vironeer-user-menu">
        <div class="vironeer-user" id="dropdownMenuButton" data-bs-toggle="dropdown">
            <div class="vironeer-user-avatar">
                <img src="<?php echo e(asset(auth()->guard('admin')->user()->avatar)); ?>"
                    alt="<?php echo e(auth()->guard('admin')->user()->name); ?>" />
            </div>
            <div class="vironeer-user-info d-none d-md-block">
                <p class="vironeer-user-title mb-0"><?php echo e(auth()->guard('admin')->user()->name); ?></p>
                <p class="vironeer-user-text mb-0"><?php echo e(auth()->guard('admin')->user()->email); ?></p>
            </div>
        </div>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li>
                <a class="dropdown-item" href="<?php echo e(route('admin.account.index')); ?>">
                    <i class="fa fa-user-edit me-2"></i>
                    <?php echo e(admin_trans('Account')); ?>

                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <?php echo e(admin_trans('Logout')); ?>

                </a>
            </li>
        </ul>
        <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
        </form>
    </div>
</header>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/includes/navbar.blade.php ENDPATH**/ ?>