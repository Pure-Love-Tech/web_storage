<?php if($code): ?>
    <?php if($alias != 'head_code'): ?>
        <div class="ad">
            <div <?php echo e($attributes); ?>>
                <?php echo $code; ?>

            </div>
        </div>
    <?php else: ?>
        <?php echo $code; ?>

    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/components/ad.blade.php ENDPATH**/ ?>