<p class="h3 mb-0 capitalize"><?php echo $__env->yieldContent('title'); ?></p>
<nav class="mt-2" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-sa-simple mb-0">
        <?php $segments = ''; ?>
        <?php $__currentLoopData = request()->segments(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $segments .= '/' . $segment; ?>
            <li class="breadcrumb-item  <?php if(request()->segment(count(request()->segments())) == $segment): ?> active <?php endif; ?>">
                <?php if(request()->segment(count(request()->segments())) != $segment): ?>
                <a href="<?php echo e(url($segments)); ?>"><?php echo e($segment); ?></a>
            <?php else: ?>
                <?php echo e($segment); ?>

        <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/includes/breadcrumb.blade.php ENDPATH**/ ?>