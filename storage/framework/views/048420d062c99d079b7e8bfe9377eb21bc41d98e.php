<?php if($oauthProviders->count() > 0): ?>
    <div class="login-with mt-3">
        <div class="login-with-divider">
            <span><?php echo e(translate('Or', 'auth')); ?></span>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $oauthProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oauthProvider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="<?php echo e($oauthProviders->count() > 1 ? 'col-lg-12 col-xl-6' : 'col-12'); ?>">
                    <a href="<?php echo e(route('oauth.login', $oauthProvider->alias)); ?>"
                        class="btn btn-<?php echo e($oauthProvider->alias); ?> btn-md w-100 text-center">
                        <i class="<?php echo e($oauthProvider->icon); ?> me-2"></i>
                        <?php echo e(translate("Sign in With {$oauthProvider->name}", 'auth')); ?>

                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/components/oauth-buttons.blade.php ENDPATH**/ ?>