<?php $__env->startSection('section', admin_trans('Admin')); ?>
<?php $__env->startSection('title', admin_trans('Reset Password')); ?>
<?php $__env->startSection('content'); ?>
    <h1 class="mb-0 h3"><?php echo e(admin_trans('Reset Password')); ?></h1>
    <p class="card-text text-muted">
        <?php echo e(admin_trans('Enter the email address associated with your account and we will send a link to reset your password.')); ?>

    </p>
    <form action="<?php echo e(route('admin.password.reset')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label"><?php echo e(admin_trans('Email Address')); ?></label>
            <input type="email" name="email" class="form-control form-control-lg" required />
        </div>
        <?php if (isset($component)) { $__componentOriginal27e3cc0d1ef3853d33ee8bbf3e5c6df69d9ef150 = $component; } ?>
<?php $component = App\View\Components\Backend\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Backend\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27e3cc0d1ef3853d33ee8bbf3e5c6df69d9ef150)): ?>
<?php $component = $__componentOriginal27e3cc0d1ef3853d33ee8bbf3e5c6df69d9ef150; ?>
<?php unset($__componentOriginal27e3cc0d1ef3853d33ee8bbf3e5c6df69d9ef150); ?>
<?php endif; ?>
        <button class="btn btn-primary btn-lg d-block w-100"><?php echo e(admin_trans('Reset Password')); ?></button>
    </form>
    <p class="mb-0 text-center text-muted mt-3"><?php echo e(admin_trans('Remember your password')); ?>? <a
            href="<?php echo e(route('admin.login')); ?>"><?php echo e(admin_trans('Login')); ?></a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/auth/passwords/email.blade.php ENDPATH**/ ?>