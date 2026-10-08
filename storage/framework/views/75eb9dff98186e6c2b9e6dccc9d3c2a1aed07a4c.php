<?php if($settings->actions->language_menu): ?>
    <div class="drop-down languages" data-dropdown data-dropdown-position="top">
        <div class="drop-down-btn">
            <div class="language-img">
                <img src="<?php echo e(asset($activeLanguage->flag)); ?>" alt="<?php echo e($activeLanguage->name); ?>" />
            </div>
            <span><?php echo e($activeLanguage->name); ?></span>
            <i class="fa fa-angle-down ms-2"></i>
        </div>
        <div class="drop-down-menu">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(localizationUrl($language->code)); ?>"
                    class="drop-down-item <?php echo e($activeLanguage->code == $language->code ? 'active' : ''); ?>">
                    <div class="language-img">
                        <img src="<?php echo e(asset($language->flag)); ?>" alt="<?php echo e($language->name); ?>" />
                    </div>
                    <span><?php echo e($language->name); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/partials/language-menu.blade.php ENDPATH**/ ?>