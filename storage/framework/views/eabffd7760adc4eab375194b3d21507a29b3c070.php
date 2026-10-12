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
            <div class="vironeer-page-body">
                <div class="py-4 g-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <?php echo $__env->make('backend.includes.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-auto">
                            <?php if (! empty(trim($__env->yieldContent('back')))): ?>
                                <a href="<?php echo $__env->yieldContent('back'); ?>" class="btn btn-secondary"><i
                                        class="fas fa-arrow-left me-2"></i><?php echo e(admin_trans('Back')); ?></a>
                            <?php endif; ?>
                            <?php if (! empty(trim($__env->yieldContent('access')))): ?>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $__env->yieldContent('access'); ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(route('admin.settings.general')); ?>"><?php echo e(admin_trans('General Settings')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(route('admin.settings.pages.index')); ?>"><?php echo e(admin_trans('Website Pages')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(route('admin.settings.smtp.index')); ?>"><?php echo e(admin_trans('SMTP Deatils')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(route('admin.settings.mailtemplates.index')); ?>"><?php echo e(admin_trans('Mail Templates')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(route('admin.settings.languages.index')); ?>"><?php echo e(admin_trans('Languages')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(route('admin.appearance.themes.index')); ?>"><?php echo e(admin_trans('Themes')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
        <?php echo $__env->make('backend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php echo $__env->make('backend.includes.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/layouts/application.blade.php ENDPATH**/ ?>