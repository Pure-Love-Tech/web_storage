<!DOCTYPE html>
<html lang="<?php echo e(getLocale()); ?>">

<head>
    <?php echo $__env->make('themes.basic.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/simplebar/simplebar.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/vironeer/vironeer-icons.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php echo $__env->make('themes.basic.includes.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'head_code'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Ad::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9)): ?>
<?php $component = $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9; ?>
<?php unset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9); ?>
<?php endif; ?>
    <?php echo $themeSettings->extra_codes->head_code; ?>

</head>

<?php echo $__env->make('themes.basic.partials.adblock-full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('head_codes'); ?>

<body class="dash-body">
    <?php echo $__env->make('themes.basic.partials.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="dash">
        <?php echo $__env->make('themes.basic.user.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="dash-inner">
            <?php echo $__env->make('themes.basic.user.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="dash-container">
                <div class="page-body">
                    <div class="row row-cols-auto g-2 justify-content-between align-items-center mb-4">
                        <div class="col">
                            <h3 class="mb-0"><?php echo $__env->yieldContent('title'); ?></h3>
                        </div>
                        <div class="col">
                            <?php if(request()->routeIs('user.dashboard')): ?>
                                <div class="dash-select">
                                    <div class="dash-select-icon">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                    <select id="period-select" class="form-select radius w-auto">
                                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(route('user.dashboard', 'period=' . $date['key'])); ?>"
                                                <?php if(request('period') == $date['key']): echo 'selected'; endif; ?>>
                                                <?php echo e($date['value']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <?php if (! empty(trim($__env->yieldContent('back')))): ?>
                                <a href="<?php echo $__env->yieldContent('back'); ?>" class="btn btn-outline-secondary radius radius-md"><i
                                        class="fa-solid fa-arrow-left me-2"></i><?php echo e(translate('Back')); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
            <?php echo $__env->make('themes.basic.includes.uploadbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('themes.basic.user.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/simplebar/simplebar.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
    <?php echo $__env->make('themes.basic.includes.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $themeSettings->extra_codes->footer_code; ?>

</body>

</html>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/layouts/app.blade.php ENDPATH**/ ?>