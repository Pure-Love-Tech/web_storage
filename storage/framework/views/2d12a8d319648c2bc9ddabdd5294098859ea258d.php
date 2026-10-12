<?php $__env->startSection('title', translate('Contact Us', 'pages')); ?>
<?php $__env->startSection('content'); ?>
    <div class="section section-start">
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    <h2 class="section-title text-capitalize mb-0"><?php echo e(translate('Contact Us', 'pages')); ?></h2>
                </div>
                <div class="section-body">
                    <form action="<?php echo e(route('contact')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row row-cols-1 row-cols-lg-3 g-3 mb-3">
                            <div class="col">
                                <label class="form-label"><?php echo e(translate('Name', 'forms')); ?> : <span
                                        class="required">*</span></label>
                                <input type="text" name="name" class="form-control form-control-md radius radius-md"
                                    value="<?php echo e(auth()->user()->name ?? old('name')); ?>" required />
                            </div>
                            <div class="col">
                                <label class="form-label"><?php echo e(translate('Email address', 'forms')); ?> : <span
                                        class="required">*</span></label>
                                <input type="email" name="email" class="form-control form-control-md radius radius-md"
                                    value="<?php echo e(auth()->user()->email ?? old('email')); ?>" required />
                            </div>
                            <div class="col">
                                <label class="form-label"><?php echo e(translate('Subject', 'forms')); ?> : <span
                                        class="required">*</span></label>
                                <input type="text" name="subject" class="form-control form-control-md radius radius-md"
                                    value="<?php echo e(old('subject')); ?>" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('Message', 'forms')); ?> : <span
                                    class="required">*</span></label>
                            <textarea type="text" name="message"class="form-control radius" rows="8" required><?php echo e(old('message')); ?></textarea>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                        <button class="btn btn-primary btn-md radius radius-md"><i
                                class="far fa-paper-plane me-2"></i><?php echo e(translate('Send', 'pages')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/contact.blade.php ENDPATH**/ ?>