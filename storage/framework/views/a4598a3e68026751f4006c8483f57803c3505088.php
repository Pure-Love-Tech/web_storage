<?php $__env->startSection('section', admin_trans('Admin')); ?>
<?php $__env->startSection('title', admin_trans('Login')); ?>
<?php $__env->startSection('content'); ?>
    <h1 class="mb-0 h3"><?php echo e(admin_trans('Login')); ?></h1>
    <p class="card-text text-muted"><?php echo e(admin_trans('Log in to your account to continue.')); ?></p>
    <form action="<?php echo e(route('admin.login.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label"><?php echo e(admin_trans('Email Address')); ?></label>
            <input type="email" name="email" class="form-control form-control-lg" value="<?php echo e(old('email')); ?>" required />
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo e(admin_trans('Password')); ?></label>
            <input type="password" name="password" class="form-control form-control-lg" required />
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <label class="form-check mb-0">
                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>

                        class="form-check-input">
                    <span class="form-check-label"><?php echo e(admin_trans('Remember me')); ?></span>
                </label>
            </div>
            <div class="col-auto ms-auto">
                <a href="<?php echo e(route('admin.password.reset')); ?>"><?php echo e(admin_trans('Forgot password')); ?>?</a>
            </div>
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
        <button class="btn btn-primary btn-lg d-block w-100"><?php echo e(admin_trans('Login')); ?></button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/auth/login.blade.php ENDPATH**/ ?>