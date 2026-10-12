<!DOCTYPE html>
<html lang="<?php echo e(getLocale()); ?>">

<head>
    <?php echo $__env->make('backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('backend.includes.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <?php echo $__env->make('backend.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="vironeer-page-content">
        <?php echo $__env->make('backend.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container <?php echo $__env->yieldContent('container'); ?>">
            <div class="vironeer-page-body px-1 px-sm-2 px-xxl-0">
                <div class="py-4 g-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <?php echo $__env->make('backend.includes.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-auto">
                            <?php if (! empty(trim($__env->yieldContent('language')))): ?>
                                <div class="dropdown d-inline me-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-globe me-2"></i><?php echo e($active); ?>

                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <?php $__currentLoopData = $adminLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adminLanguage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a class="dropdown-item <?php if($adminLanguage->name == $active): ?> active <?php endif; ?>"
                                                    href="?lang=<?php echo e($adminLanguage->code); ?>"><?php echo e($adminLanguage->name); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (! empty(trim($__env->yieldContent('back')))): ?>
                                <a href="<?php echo $__env->yieldContent('back'); ?>" class="btn btn-secondary me-2"><i
                                        class="fas fa-arrow-left me-2"></i><?php echo e(admin_trans('Back')); ?></a>
                            <?php endif; ?>
                            <?php if (! empty(trim($__env->yieldContent('link')))): ?>
                                <a href="<?php echo $__env->yieldContent('link'); ?>" class="btn btn-dark me-2"><i class="fa fa-plus"></i></a>
                            <?php endif; ?>
                            <?php if (! empty(trim($__env->yieldContent('modal')))): ?>
                                <button type="button" class="btn btn-dark me-2" data-bs-toggle="modal"
                                    data-bs-target="#viewModal">
                                    <?php echo $__env->yieldContent('modal'); ?>
                                </button>
                            <?php endif; ?>
                            <button form="vironeer-submited-form" class="btn btn-primary <?php echo $__env->yieldContent('btn_action'); ?>"
                                <?php echo $__env->yieldContent('btn_action'); ?>><?php echo e(admin_trans('Save')); ?></button>
                        </div>
                    </div>
                </div>
                <div class="vironeer-form-page">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
        <?php echo $__env->make('backend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php echo $__env->make('backend.includes.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/layouts/form.blade.php ENDPATH**/ ?>