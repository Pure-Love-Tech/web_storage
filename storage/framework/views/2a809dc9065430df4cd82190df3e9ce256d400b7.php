<div class="mb-4">
    <div class="file-title mb-4">
        <div class="row row-cols-auto justify-content-center text-center g-2">
            <div class="col">
                <span class="text-primary h3"><?php echo e(translate('Download File', 'download pages')); ?></span>
            </div>
            <div class="col">
                <span class="text-break h3"><?php echo e($fileEntry->getFullName()); ?></span>
            </div>
        </div>
    </div>
    <div class="file-request">
        <div class="row row-cols-auto justify-content-center text-center gx-2 gy-3">
            <div class="col">
                <span><?php echo e(translate('You have requested', 'download pages')); ?></span>
            </div>
            <div class="col">
                <span class="text-break text-primary"><?php echo e($fileEntry->sharedLink()); ?></span>
            </div>
            <div class="col">
                <span>(<?php echo e($fileEntry->getFullSize()); ?>)</span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/files/common/title.blade.php ENDPATH**/ ?>