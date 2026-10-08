<?php $__env->startSection('section', translate('Download', 'download pages')); ?>
<?php $__env->startSection('title', $fileEntry->name); ?>
<?php $__env->startSection('hide_header', true); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
	.btn-download {
    position: relative;
    overflow: hidden;
    border: 0;
    padding: 15px 24px;
    font-size: 1.05rem;
    font-weight: 800;
    letter-spacing: 0.2px;
    color: #fff;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    box-shadow: 0 8px 22px rgba(34, 197, 94, 0.35);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-download:hover {
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(34, 197, 94, 0.45);
}

.btn-download:active {
    transform: translateY(0);
}

/* Efek kilau */
.btn-download::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 70%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.25),
        transparent
    );
    transform: skewX(-20deg);
    animation: buttonShine 3s infinite;
}

@keyframes buttonShine {
    0% {
        left: -120%;
    }

    45%,
    100% {
        left: 150%;
    }
}
</style>
    <div class="section download-section">
        <div class="container">
            <div class="section-inner">
                <div class="custom-container">
                    <div class="section-body">
                        <?php echo $__env->make('themes.basic.files.common.title', [
                            'fileEntry' => $fileEntry,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_1_top'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Ad::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses('ad-970x250 mb-4'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9)): ?>
<?php $component = $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9; ?>
<?php unset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9); ?>
<?php endif; ?>
                        <div class="file-card">
                            <div class="file-details">
                                <?php echo $__env->make('themes.basic.files.common.details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_1_center_top'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Ad::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses('ad-970x250 mb-4'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9)): ?>
<?php $component = $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9; ?>
<?php unset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9); ?>
<?php endif; ?>
                                <div class="col-lg-12 m-auto download-section-box">
                                    <?php if(licenseType(2)): ?>
                                        <h5 class="text-center mb-5">
                                            <?php echo e(translate('Choose Download Type', 'download pages')); ?>

                                        </h5>
                                    <?php endif; ?>
                                    <div class="row row-cols-1 row-cols-lg-12 justify-content-center g-4">
                                        <div class="col-12">
                                            <div class="download-type">
                                                <form action="<?php echo e(route('files.file', $fileEntry->sharedId())); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="p" value="down_1">
                                                    <input type="hidden" name="method" value="free">
                                                    <button class="btn btn-download btn-lg radius w-100 fw-1000">
													    <?php if(licenseType(2)): ?>
													        <?php echo e(translate('Free Download', 'download pages')); ?>

													    <?php else: ?>
													        <?php echo e(translate('Continue To Download', 'download pages')); ?>

													        <i class="fa-solid fa-arrow-right ms-2"></i>
													    <?php endif; ?>
													</button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php if(licenseType(2)): ?>
                                            <div class="col">
                                                <div class="download-type">
                                                    <form action="<?php echo e(route('files.file', $fileEntry->sharedId())); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="p" value="down_1">
                                                        <input type="hidden" name="method" value="premium">
                                                        <button class="btn btn-primary btn-md radius w-100 fw-500">
                                                            <i class="fa fa-star me-1"></i>
                                                            <?php echo e(translate('Premium Download', 'download pages')); ?>

                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_1_center_bottom'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Ad::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses('ad-970x250 mt-4'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9)): ?>
<?php $component = $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9; ?>
<?php unset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9); ?>
<?php endif; ?>
                            </div>
                            <?php if($themeSettings->download_pages->file_about): ?>
                                <?php echo $__env->make('themes.basic.files.common.about', [
                                    'fileEntry' => $fileEntry,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_1_bottom'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Ad::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses('ad-970x250 mt-5'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9)): ?>
<?php $component = $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9; ?>
<?php unset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9); ?>
<?php endif; ?>
                        <?php if($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page1_extra_text): ?>
                            <div class="file-card mt-5">
                                <?php echo $themeSettings->download_pages->page1_extra_text; ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- adsterra -->
	<script src="https://falconhoe.com/e8/e5/a2/e8e5a20fbedb5947a51dcfc27151c654.js"></script>

    <?php $__env->startPush('head_codes'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        if (typeof gtag === 'function') {
            gtag('event', 'download_step_1', {
                download_method: 'free'
            });
        }
    });
    </script>

    <!-- addsterra -->
	<script src="https://falconhoe.com/20/5e/16/205e16a3db53f6a22db869a839d7e124.js"></script>

<!-- <script src="https://quge5.com/88/tag.min.js" data-zone="272740" async data-cfasync="false"></script> -->
<?php $__env->stopPush(); ?>

    <?php $__env->startPush('config'); ?>
        <?php echo $__env->make('themes.basic.files.common.config', [
            'fileEntry' => $fileEntry,
            'downloadPlan' => subscription()->plan,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/files/download1.blade.php ENDPATH**/ ?>