<?php $__env->startSection('section', translate('Download', 'download pages')); ?>
<?php $__env->startSection('title', $fileEntry->name); ?>
<?php $__env->startSection('hide_header', true); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .download-file-info {
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            padding: 20px;
            background: var(--bs-body-bg);
        }

        .download-file-info-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .download-file-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bs-secondary-bg);
            font-size: 22px;
        }

        .download-file-name h5 {
            font-weight: 600;
            margin: 0;
        }

        .download-file-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--bs-border-color);
        }

        .download-meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .download-meta-label {
            font-size: 13px;
            color: var(--bs-secondary-color);
        }

        .download-meta-item strong {
            font-size: 14px;
            font-weight: 600;
        }

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

        @media (max-width: 767px) {
            .download-file-meta {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }
    </style>
    <div class="section download-section">
        <div class="container">
            <div class="section-inner">
                <div class="custom-container">
                    <div class="section-body"> <?php echo $__env->make('themes.basic.files.common.title', ['fileEntry' => $fileEntry], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_3_top'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                            <div class="file-details"> <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_3_center_top'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
<?php endif; ?>  <div
                                    class="download-file-info mb-4">
                                    <div class="download-file-header">
                                        <div class="download-file-icon"> <?php echo $fileEntry->getFileIcon(''); ?> </div>
                                        <div class="download-file-title">
                                            <h5 class="mb-1 text-break"> <?php echo e($fileEntry->getFullName()); ?> </h5> <span
                                                class="text-muted"> <?php echo e(translate('File information', 'download pages')); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="download-file-meta">  <div class="download-meta-item">
                                            <div class="download-meta-label"> <i
                                                    class="fa-solid fa-weight-hanging me-1"></i>
                                                <?php echo e(translate('File Size', 'download pages')); ?> </div>
                                            <div class="download-meta-value"> <?php echo e(formatBytes($fileEntry->size)); ?> </div>
                                        </div>  <div class="download-meta-item">
                                            <div class="download-meta-label"> <i class="fa-solid fa-file-lines me-1"></i>
                                                <?php echo e(translate('File Type', 'download pages')); ?> </div>
                                            <div class="download-meta-value">
                                                <?php echo e(strtoupper($fileEntry->extension ?: 'FILE')); ?> </div>
                                        </div>  <?php if($fileEntry->mime): ?>
                                            <div class="download-meta-item">
                                                <div class="download-meta-label"> <i class="fa-solid fa-code me-1"></i>
                                                    <?php echo e(translate('Format', 'download pages')); ?> </div>
                                                <div class="download-meta-value text-break"> <?php echo e($fileEntry->mime); ?> </div>
                                            </div>
                                            <?php endif; ?>  <div class="download-meta-item">
                                                <div class="download-meta-label"> <i class="fa-solid fa-download me-1"></i>
                                                    <?php echo e(translate('Downloads', 'download pages')); ?> </div>
                                                <div class="download-meta-value"> <?php echo e(number_format($fileEntry->downloads)); ?>

                                                </div>
                                            </div>  <div class="download-meta-item">
                                                <div class="download-meta-label"> <i
                                                        class="fa-regular fa-calendar me-1"></i>
                                                    <?php echo e(translate('Uploaded', 'download pages')); ?> </div>
                                                <div class="download-meta-value">
                                                    <?php echo e($fileEntry->created_at->format('d M Y')); ?> </div>
                                            </div>  <?php if($fileEntry->expiry_at): ?>
                                                <div class="download-meta-item">
                                                    <div class="download-meta-label"> <i
                                                            class="fa-regular fa-clock me-1"></i>
                                                        <?php echo e(translate('Available Until', 'download pages')); ?> </div>
                                                    <div class="download-meta-value">
                                                        <?php echo e($fileEntry->expiry_at->format('d M Y')); ?> </div>
                                                </div>
                                                <?php endif; ?> </div>
                                </div>  <div class="row g-4 text-center">
                                    <div class="col-12 col-xl-7 mx-auto download-section-box">
                                        <div class="download-file-link my-4">
                                            <?php if($downloadPlan->download_waiting_time > 0): ?>
                                                <h3 class="mb-4">
                                                    <?php echo e(translate('We are generating your download link', 'download pages')); ?>

                                                </h3>
                                                <p
                                                    class="download-file-timer d-flex align-items-center justify-content-center text-center mb-4">
                                                    <?php echo str(translate('Please wait {seconds} Seconds', 'download pages'))->replace(
                                                        '{seconds}',
                                                        '<span class="h4 mx-2 text-secondary mb-0">' . $downloadPlan->download_waiting_time . '</span>',
                                                    ); ?> </p>
                                            <?php else: ?>
                                                <h3 class="mb-4">
                                                    <?php echo e(translate('Your download is ready', 'download pages')); ?> </h3>
                                                <?php endif; ?> <a href="#" id="finalDownloadButton"
                                                    class="btn <?php echo e($method == 'free' ? 'btn-secondary' : 'btn-primary'); ?> btn-download btn-lg fw-1000 w-100 disabled">
                                                    <i class="fa-solid fa-download me-1"></i>
                                                    <?php echo e(translate('Click Here to Download', 'download pages')); ?> </a>
                                        </div>
                                    </div>
                                </div> <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_3_center_bottom'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                        </div> <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'download_page_3_bottom'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                        <?php if($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page3_extra_text): ?>
                            <div class="file-card mt-5"> <?php echo $themeSettings->download_pages->page3_extra_text; ?> </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script src="https://falconhoe.com/e8/e5/a2/e8e5a20fbedb5947a51dcfc27151c654.js"></script>

<?php $__env->startPush('head_codes'); ?>
	<script src="https://falconhoe.com/20/5e/16/205e16a3db53f6a22db869a839d7e124.js"></script>

    <!-- profiton -->
    <!-- popunder -->
   <!-- <script data-cfasync="false" async type="text/javascript" src="//uq.jibmanbludger.com/rbROys0mZWKniWpYi/151540"></script> -->
    <!-- shuffle -->
   <!-- <script data-cfasync="false" async type="text/javascript" src="//ss.skeansleeful.com/sLvu8cCSCSLwa/151541"></script> -->
    <!-- side btn -->
   <!-- <script data-cfasync="false" async type="text/javascript" src="//cinchaslack.com/gLRmrLHzdSoVA/151542"></script> -->

	   <!--  <script>
			(function(cwj){
			var d = document,
			    s = d.createElement('script'),
			    l = d.scripts[d.scripts.length - 1];
			s.settings = cwj || {};
			s.src = "\/\/juvenilechoice.com\/b-XKVfs.dnGCl\/0sYXWpcI\/pe\/mO9FuyZGUrlDkFPiTacSzDNUDNcK4SMOzlcat\/NPzZMj0ON\/zYgg0GMQQO";
			s.async = true;
			s.referrerPolicy = 'no-referrer-when-downgrade';
			l.parentNode.insertBefore(s, l);
			})({})
	</script> -->

    <!-- <script>
        (function(nxewsrq){
        var d = document,
            s = d.createElement('script'),
            l = d.currentScript || d.scripts[d.scripts.length - 1];
        s.settings = nxewsrq || {};
        s.src = "\/\/second-director.com\/cWDC9.6\/bL2O5ilSS_WEQ\/9dNvzjQpwHNQD_AV3TNMy\/0j3wN\/DUAc0\/MgDwgLxY";
        s.async = true;
        s.referrerPolicy = 'no-referrer-when-downgrade';
        l.parentNode.insertBefore(s, l);
        })({})
    </script> -->

<!-- 	<script>
		(function(optf){
		var d = document,
		    s = d.createElement('script'),
		    l = d.currentScript || d.scripts[d.scripts.length - 1];
		s.settings = optf || {};
		s.src = "\/\/second-director.com\/ckDu9.6JbC2x5Il\/S\/WAQP9VNFzCQ_w\/NHD\/A\/3NNzyk0\/3-NyDkAb0gMAD\/gBxF";
		s.async = true;
		s.referrerPolicy = 'no-referrer-when-downgrade';
		l.parentNode.insertBefore(s, l);
		})({})
		</script> -->
	<script>
		document.addEventListener('DOMContentLoaded', function () {

		    if (typeof gtag === 'function') {
		        gtag('event', 'download_step_3', {
		            download_method: <?php echo json_encode($method, 15, 512) ?>
		        });
		    }

		    const button = document.getElementById('finalDownloadButton');

		    if (button) {
		        button.addEventListener('click', function () {
		            if (
		                !button.classList.contains('disabled') &&
		                typeof gtag === 'function'
		            ) {
		                gtag('event', 'download_click', {
		                    download_method: <?php echo json_encode($method, 15, 512) ?>
		                });
		            }
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

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/files/download3.blade.php ENDPATH**/ ?>