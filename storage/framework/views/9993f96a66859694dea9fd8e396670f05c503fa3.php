<?php $__env->startSection('title', 'FAQs'); ?>

<?php $__env->startSection('content'); ?>
    <div class="section section-start">
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    
                </div>
                <div class="section-body">
                    <div class="faqs" data-aos="fade-up" data-aos-duration="1000">
                        <div class="accordion-custom">
                            <div class="accordion" id="accordion">
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faqs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?php echo e($faqs->id); ?>">
                                            <button class="accordion-button <?php echo e(!$loop->first ? 'collapsed' : ''); ?>"
                                                type="button" data-bs-toggle="collapse" style="border : 1px solid #4194e6"
                                                data-bs-target="#collapse<?php echo e($faqs->id); ?>" aria-expanded="false"
                                                aria-controls="flush-collapseOne">
                                                <?php echo e($faqs->title); ?>

                                                <div class="accordion-button-icon">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse<?php echo e($faqs->id); ?>"
                                            class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>"
                                            aria-labelledby="heading<?php echo e($faqs->id); ?>" data-bs-parent="#accordion">
                                            <div class="accordion-body" style="background: #d9e9fa !important">
                                                <?php echo $faqs->body; ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('styles_libs'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/aos/aos.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('vendor/libs/swiper/swiper-bundle.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts_libs'); ?>
        <script src="<?php echo e(asset('vendor/libs/aos/aos.min.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/libs/swiper/swiper-bundle.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/faq.blade.php ENDPATH**/ ?>