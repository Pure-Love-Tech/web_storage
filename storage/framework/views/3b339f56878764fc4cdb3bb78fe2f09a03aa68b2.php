<div class="row row-cols-1 row-cols-lg-2 g-4 mb-5">
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-calendar-alt"></i>
            </div>
            <p class="file-details-item-text">
                <span><?php echo e(translate('Date', 'download pages')); ?>:</span>
                <?php echo e(dateFormat($fileEntry->created_at)); ?>

            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-user"></i>
            </div>
            <p class="file-details-item-text">
                <span><?php echo e(translate('Uploaded By', 'download pages')); ?>:</span>
                <?php echo e($fileEntry->user ? $fileEntry->user->name : translate('Anonymous', 'download pages')); ?>

            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-hard-drive"></i>
            </div>
            <p class="file-details-item-text">
                <span><?php echo e(translate('Size', 'download pages')); ?>:</span>
                <?php echo e($fileEntry->getFullSize()); ?>

            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-download"></i>
            </div>
            <p class="file-details-item-text">
                <span><?php echo e(translate('Downloads', 'download pages')); ?>:</span>
                <?php echo e(formatNumber($fileEntry->downloads)); ?>

            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item sm">
            <div class="file-details-item-icon">
                <i class="fa fa-share"></i>
            </div>
            <div class="file-details-item-text">
                <div class="socials socials-sm ">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($fileEntry->sharedLink()); ?>"
                        class="social-btn social-btn-sm social-facebook" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo e($fileEntry->sharedLink()); ?>"
                        class="social-btn social-btn-sm social-twitter" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo e($fileEntry->sharedLink()); ?>"
                        class="social-btn social-btn-sm social-linkedin" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://wa.me/?text=<?php echo e($fileEntry->sharedLink()); ?>"
                        class="social-btn social-btn-sm social-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="http://pinterest.com/pin/create/button/?url=<?php echo e($fileEntry->sharedLink()); ?>"
                        class="social-btn social-btn-sm social-pinterest" target="_blank">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
        $reportFileStatus = auth()->user() && $fileEntry->user_id == auth()->user()->id ? false : true;
    ?>
    <?php if($reportFileStatus): ?>
        <div class="col">
            <div class="file-details-item">
                <div class="file-details-item-icon">
                    <i class="fa-solid fa-bug"></i>
                </div>
                <p class="file-details-item-text alert-danger">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#reportModal"
                        class="link link-danger"><?php echo e(translate('Send Report', 'download pages')); ?></a>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if($reportFileStatus): ?>
    <div id="reportModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(translate('Report this file', 'download pages')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('files.file.report', $fileEntry->sharedId())); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3 mb-3">
                            <div class="col-lg-6">
                                <label class="form-label"><?php echo e(translate('Name', 'download pages')); ?> : <span
                                        class="required">*</span></label>
                                <input type="name" name="name"
                                    class="form-control form-control-md radius radius-md"
                                    value="<?php echo e(auth()->user()->name ?? ''); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label"><?php echo e(translate('Email', 'download pages')); ?> : <span
                                        class="required">*</span></label>
                                <input type="email" name="email"
                                    class="form-control form-control-md radius radius-md"
                                    value="<?php echo e(auth()->user()->email ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('Reason for reporting', 'download pages')); ?> :
                                <span class="required">*</span></label>
                            <select name="reason" class="form-select form-select-md radius radius-md" required>
                                <?php $__currentLoopData = \App\Models\FileReport::reasons(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reasonsKey => $reasonsValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($reasonsKey); ?>"><?php echo e($reasonsValue); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('Details', 'download pages')); ?> : <span
                                    class="required">*</span></label>
                            <textarea name="details" class="form-control radius radius-md" rows="7"
                                placeholder="<?php echo e(translate('Describe the reason why you reported the file to a maximum of 600 characters', 'download pages')); ?>"
                                required></textarea>
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
                        <button type="submit"
                            class="btn btn-primary btn-md radius radius-md"><?php echo e(translate('Send', 'download pages')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/files/common/details.blade.php ENDPATH**/ ?>