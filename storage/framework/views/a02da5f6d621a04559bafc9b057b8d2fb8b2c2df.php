<?php $__env->startSection('title', $page->title); ?>
<?php $__env->startSection('description', $page->short_description); ?>
<?php $__env->startSection('content'); ?>
    <div class="section section-start" style="padding-top: unset">
        
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    
                </div>
                <div class="section-body">
                    <?php echo $page->content; ?>

                </div>
            </div>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/page.blade.php ENDPATH**/ ?>