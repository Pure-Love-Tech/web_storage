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
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_2_top'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                                <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_2_center_top'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                                <div class="row g-4 text-center">
                                    <div class="col-12 col-xl-7 mx-auto download-section-box">
                                        <form id="down_2Form" action="<?php echo e(route('files.file', $fileEntry->sharedId())); ?>"
                                            method="POST">
                                            <div class="d-flex flex-column align-items-center">
                                                <?php if($settings->general->default_captcha && $downloadPlan->download_captcha): ?>
                                                    <div class="mb-3">
                                                        <?php
                                                            $callback = ['data-callback' => 'recaptchaCallback'];
                                                        ?>
                                                        <?php if (isset($component)) { $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve(['callback' => $callback] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243)): ?>
<?php $component = $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243; ?>
<?php unset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243); ?>
<?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="hidden" name="p" value="down_2">
                                                <input type="hidden" name="method" value="<?php echo e($method); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button
                                                    class="btn btn-download <?php echo e($method == 'free' ? 'btn-secondary' : 'btn-primary'); ?> btn-lg w-100 fw-1000"
                                                    disabled>
                                                    <?php echo e(translate('Create Download Link', 'download pages')); ?>

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_2_center_bottom'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                                <?php if($themeSettings->download_pages->file_about): ?>
                                    <?php echo $__env->make('themes.basic.files.common.about', [
                                        'fileEntry' => $fileEntry,
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_2_bottom'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                        <?php if($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page2_extra_text): ?>
                            <div class="file-card mt-5">
                                <?php echo $themeSettings->download_pages->page2_extra_text; ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('head_codes'); ?>
    <!-- monetag -->
    <script>(function(s){s.dataset.zone='11642163',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
    <script src="https://5gvci.com/act/files/tag.min.js?z=11642173" data-cfasync="false" async></script>
    <script>(function(s){s.dataset.zone='11642175',s.src='https://nap5k.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof gtag === 'function') {
        gtag('event', 'download_step_2', {
            download_method: <?php echo json_encode($method, 15, 512) ?>
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

    <?php $__env->startPush('config'); ?>
        <?php echo $__env->make('themes.basic.files.common.config', [
            'fileEntry' => $fileEntry,
            'downloadPlan' => $downloadPlan,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/files/download2.blade.php ENDPATH**/ ?>