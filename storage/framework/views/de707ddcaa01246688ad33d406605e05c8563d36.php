<?php $__env->startSection('title', $seoConfiguration->title ?? ''); ?>
<?php $__env->startSection('content'); ?>
    <?php if($themeSettings->home_page->header_section): ?>
        <header class="header">
            <div class="wrapper">
                <div class="header-bg"
                    style="background-image: url(<?php echo e(asset($themeSettings->home_page->header_background)); ?>);">
                </div>
                <div class="container">
                    <div class="wrapper-content">
                        <div class="wrapper-container">
                            <div class="row row-cols-2 align-items-center g-4">
                                <div class="col-12 col-lg-5 order-2 order-lg-1">
                                    <h1 class="header-title" data-aos="fade-right" data-aos-duration="1000">
                                        <?php echo e(translate('Upload Files & Earn Money', 'home page')); ?>

                                    </h1>
                                    <p class="header-text lead text-muted" data-aos="fade-right" data-aos-duration="1000">
                                        <?php echo e(translate('hero_description', 'home page')); ?>

                                    </p>
                                    <div data-aos="fade-up" data-aos-duration="1000">
                                        <?php if(subscription()->plan->upload_status): ?>
                                            <button class="btn btn-primary btn-lg" data-upload-btn><i
                                                    class="fa-solid fa-arrow-up-from-bracket me-2"></i><?php echo e(translate('Upload Files', 'home page')); ?></button>
                                        <?php else: ?>
                                            <a href="<?php echo e(auth()->user() ? route('user.settings.subscription') : route('login')); ?>"
                                                class="btn btn-primary btn-lg"><i
                                                    class="fa-solid fa-arrow-up-from-bracket me-2"></i><?php echo e(translate('Upload Files', 'home page')); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-7 order-1 order-lg-2">
                                    <div class="header-img" data-aos="zoom-in" data-aos-duration="1000">
                                        <img src="<?php echo e(asset($themeSettings->home_page->header_image)); ?>"
                                            alt="<?php echo e($settings->general->site_name); ?>" style="width: 110% !important; max-width: 1000px !important;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>
    
    <?php if($themeSettings->home_page->features_section && $features->count() > 0): ?>
        <style>
            .feature-icon {
                display: grid;
                place-items: center;
            }

            .feature-icon img {
                display: block;
                margin-left: 10px !important;
                object-fit: contain;
            }

            .feature .feature-icon::before {
                width: 55px;
                height: 55px;
            }
        </style>
        <div class="section section-start"
            style="background-image: url(<?php echo e(asset($themeSettings->home_page->section_background_image)); ?>);">
            <div class="container">
                <div class="section-inner">
                    <div class="row g-5 align-items-center">
                        <div class="col-12 col-lg-7 col-xxl-6 order-2 order-lg-1" data-aos="fade-right"
                            data-aos-duration="1000">
                            <div class="section-body">
                                <div class="row row-cols-1 row-cols-sm-2 g-4 align-items-center">
                                    <?php
                                        $featuresCounter = 0;
                                    ?>
                                    <?php $__currentLoopData = $features->chunk(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col">
                                            <div class="row row-cols-1 g-4">
                                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                                        <div
                                                            class="feature <?php echo e($featuresCounter % 2 == 1 ? ' feature-secondary' : ''); ?>">
                                                            <div class="feature-icon">
                                                                <img src="<?php echo e(asset($feature->image)); ?>"
                                                                    alt="<?php echo e($feature->title); ?>" />
                                                            </div>
                                                            <h5 class="feature-title"><?php echo e($feature->title); ?></h5>
                                                            <p class="feature-text text-muted"><?php echo e($feature->body); ?></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $featuresCounter++;
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 col-xxl-6 order-1 order-lg-2" data-aos="fade-left"
                            data-aos-duration="1000">
                            <div class="section-header mb-0">
                                <h2 class="section-title"><?php echo e(translate('Our Features', 'home page')); ?></h2>
                                <p class="section-text text-muted lead">
                                    <?php echo e(translate('features description', 'home page')); ?></p>
                                <?php if(auth()->guard()->guest()): ?>
                                    <div class="d-flex justify-content-end">
                                        <a href="<?php echo e(route('register')); ?>"
                                            class="btn btn-primary btn-md"><i class="fa-solid fa-chevron-right me-2"></i><?php echo e(translate('Get Started', 'home page')); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($themeSettings->home_page->steps_section && $steps->count() > 0): ?>
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo e(translate('How it Works', 'home page')); ?></h2>
                        <p class="section-text text-muted lead"><?php echo e(translate('How it Works Description', 'home page')); ?>

                        </p>
                    </div>
                    <div class="section-body">
                        <div class="steps">
                            <div class="steps-border">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1587.904" height="309.319"
                                    viewBox="0 0 1587.904 309.319">
                                    <path id="Path_4115" data-name="Path 4115"
                                        d="M-5287.292-3794.361c49.612,33.755,149.847,128.154,198.448,135.021,25.759,3.64,32.252-19.748,19.811-35.13-10.691-13.22-33.506-12.486-39.092-7.4-11.886,10.83-49.988,78.383,19.282,101.428s150.428-36.252,310.889-8.188,150.087,128.105,330.955,120.445,392.513-151.086,392.513-151.086,169.3-39.945,176.487-84.645-78.219-15.853-49.2,7.919,226.344,114.767,226.344,114.767"
                                        transform="translate(5288.135 3795.601)" fill="none" class="stroke-color"
                                        stroke-width="3" stroke-dasharray="10" />
                                </svg>
                            </div>
                            <div class="row row-cols-1 row-cols-lg-3 g-4">
                                <?php
                                    $stepCounter = 1;
                                ?>
                                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stepKey => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                        <div
                                            class="step <?php echo e($stepCounter == 2 ? 'step-primary step-margin' : 'step-secondary'); ?>">
                                            <div class="step-number"><?php echo e($stepCounter); ?></div>
                                            <h4 class="step-title"><?php echo e($step->title); ?></h4>
                                            <p class="step-text"><?php echo e($step->body); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                        $stepCounter++;
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if($themeSettings->home_page->faqs_section && $faqs->count() > 0): ?>
        
    <?php endif; ?>
    <?php if($themeSettings->home_page->blog_section && $settings->actions->blog_status && $blogArticles->count() > 0): ?>
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo e(translate('Latest Blog Posts', 'home page')); ?></h2>
                        <p class="section-text text-muted lead">
                            <?php echo e(translate('Latest Blog Posts Description', 'home page')); ?>

                        </p>
                    </div>
                    <div class="section-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center g-3">
                            <?php $__currentLoopData = $blogArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                    <?php echo $__env->make('themes.basic.partials.blog-post', [
                                        'post' => $post,
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="d-flex justify-content-center mt-4" data-aos="fade-up" data-aos-duration="1000">
                            <a href="<?php echo e(route('blog.index')); ?>" class="btn btn-secondary btn-icon btn-md">
                                <?php echo e(translate('View All Blog Posts', 'home page')); ?>

                                <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if($themeSettings->home_page->withdrawal_methods_section): ?>
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo e(translate('Withdrawal Methods', 'home page')); ?></h2>
                    </div>
                    <div class="section-body">
                        <div class="swiper-container" data-aos="fade-up" data-aos-duration="1000">
                            <div class="swiper swiper-brands">
                                <div class="swiper-wrapper align-items-center">
                                    <?php $__currentLoopData = $withdrawalMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawalMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <div class="brand">
                                                <img src="<?php echo e(asset($withdrawalMethod->logo)); ?>"
                                                    alt="<?php echo e($withdrawalMethod->name); ?>" />
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="swiper-actions">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php echo $__env->make('themes.basic.includes.uploadbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/aos/aos.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/swiper/swiper-bundle.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/aos/aos.min.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/libs/swiper/swiper-bundle.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/home.blade.php ENDPATH**/ ?>