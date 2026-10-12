<div class="nav-bar <?php echo e($__env->yieldContent('hide_header') ? 'active' : ''); ?>">
    <div class="container">
        <div class="nav-bar-container">
            <a href="<?php echo e(route('home')); ?>" class="logo">
                <img src="<?php echo e(asset($themeSettings->general->logo_dark)); ?>" alt="<?php echo e($settings->general->site_name); ?>" style="width:200px; height:auto"/>
            </a>
            <div class="nav-bar-menu">
                <div class="overlay"></div>
                <div class="nav-bar-links">
                    <div class="nav-bar-menu-header">
                        <a class="nav-bar-menu-close ms-auto">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <?php $__currentLoopData = $navbarMenuLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navbarMenuLink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($navbarMenuLink->children->count() > 0): ?>
                            <div class="drop-down" data-dropdown data-dropdown-position="top">
                                <div class="drop-down-btn">
                                    <span><?php echo e($navbarMenuLink->name); ?></span>
                                    <i class="fa fa-angle-down ms-2"></i>
                                </div>
                                <div class="drop-down-menu">
                                    <?php $__currentLoopData = $navbarMenuLink->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e($child->link); ?>" class="drop-down-item">
                                            <span><?php echo e($child->name); ?></span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e($navbarMenuLink->link); ?>" class="link">
                                <div class="link-title">
                                    <span><?php echo e($navbarMenuLink->name); ?></span>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('themes.basic.partials.language-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="link-btn">
                            <button class="btn btn-secondary"><?php echo e(translate('Sign In', 'auth')); ?></button>
                        </a>
                        <?php if($settings->actions->registration_status): ?>
                            <a href="<?php echo e(route('register')); ?>" class="link-btn">
                                <button class="btn btn-primary"><?php echo e(translate('Sign Up', 'auth')); ?></button>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="nav-bar-actions">
                <?php if(auth()->guard()->check()): ?>
                    <?php echo $__env->make('themes.basic.partials.user-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <div class="nav-bar-menu-btn">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/includes/navbar.blade.php ENDPATH**/ ?>