<?php if (isset($component)) { $__componentOriginal057ee741994856236e7cb66eea85cb4b6d9d26bc = $component; } ?>
<?php $component = App\View\Components\Partials::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('partials'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Partials::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal057ee741994856236e7cb66eea85cb4b6d9d26bc)): ?>
<?php $component = $__componentOriginal057ee741994856236e7cb66eea85cb4b6d9d26bc; ?>
<?php unset($__componentOriginal057ee741994856236e7cb66eea85cb4b6d9d26bc); ?>
<?php endif; ?>
<script>
    "use strict";
    const config = <?php echo json_encode([
        'lang' => getLocale(),
        'url' => url('/'),
        'colors' => $themeSettings->colors,
        'translates' => [
            'copied' => translate('Copied to clipboard'),
            'actionConfirm' => translate('Are you sure?'),
        ],
    ]); ?>;
</script>
<?php echo $__env->yieldPushContent('config'); ?>
<?php echo $__env->yieldPushContent('top_scripts'); ?>
<script src="<?php echo e(asset('vendor/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts_libs'); ?>
<!-- <script src="<?php echo e(theme_asset('assets/js/app.js')); ?>"></script> -->
<script src="<?php echo e(theme_asset('assets/js/app.js')); ?>?v=<?php echo e(filemtime(public_path('themes/basic/assets/js/app.js'))); ?>"></script>
<?php echo app('toastr')->render(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/includes/scripts.blade.php ENDPATH**/ ?>