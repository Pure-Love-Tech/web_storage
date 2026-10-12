<?php $__env->startSection('title', translate('Settings', 'settings')); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('themes.basic.user.settings.includes.links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="card-v">
        <h5 class="mb-0"><?php echo e(translate('Account details', 'settings')); ?></h5>
        <form id="deatilsForm" action="<?php echo e(route('user.settings.details.update')); ?>" method="POST"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-section">
                <div class="row g-4 align-items-center">
                    <div class="col-auto">
                        <div class="settings-user-img">
                            <img id="preview-img-1" src="<?php echo e(asset($user->avatar)); ?>" alt="<?php echo e($user->name); ?>">
                            <input id="image-targeted-input-1" type="file" name="avatar"
                                accept="image/png, image/jpg, image/jpeg" hidden>
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-light radius radius-md select-image-button" data-id="1"><i
                                class="fa fa-camera me-2"></i><?php echo e(translate('Choose Avatar', 'settings')); ?></button>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <label class="form-label"><?php echo e(translate('First Name', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <input type="firstname" name="firstname" class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('First Name', 'forms')); ?>" maxlength="50"
                            value="<?php echo e($user->firstname); ?>" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label"><?php echo e(translate('Last Name', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <input type="lastname" name="lastname" class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('Last Name', 'forms')); ?>" maxlength="50"
                            value="<?php echo e($user->lastname); ?>" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label"><?php echo e(translate('Username', 'forms')); ?> : </label>
                        <input class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('Username', 'forms')); ?>" value="<?php echo e($user->username); ?>" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo e(translate('Email address', 'forms')); ?> : <span
                                class="required">*</span></label>
                        <input type="email" name="email" class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('Email address', 'forms')); ?>" value="<?php echo e($user->email); ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo e(translate('Phone Number', 'forms')); ?> : </label>
                        <input type="tel" name="mobile" class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('Phone Number', 'forms')); ?>" value="<?php echo e($user->mobile); ?>">
                    </div>
                </div>
            </div>
            <div class="form-section mb-4">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo e(translate('Address line 1', 'forms')); ?> : </label>
                        <input type="text" name="address_1" class="form-control form-control-md radius radius-md"
                            value="<?php echo e(@$user->address->address_1); ?>"
                            placeholder="<?php echo e(translate('Address line 1', 'forms')); ?>">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label"><?php echo e(translate('Address line 2', 'forms')); ?> : </label>
                        <input type="text" name="address_2" class="form-control form-control-md radius radius-md"
                            placeholder="<?php echo e(translate('Address line 2', 'forms')); ?>"
                            value="<?php echo e(@$user->address->address_2); ?>">
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('City', 'forms')); ?> : </label>
                            <input type="text" name="city" class="form-control form-control-md radius radius-md"
                                value="<?php echo e(@$user->address->city); ?>" placeholder="<?php echo e(translate('City', 'forms')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('State', 'forms')); ?> : </label>
                            <input type="text" name="state" class="form-control form-control-md radius radius-md"
                                value="<?php echo e(@$user->address->state); ?>" placeholder="<?php echo e(translate('State', 'forms')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('Postal code', 'forms')); ?> : </label>
                            <input type="text" name="zip" class="form-control form-control-md radius radius-md"
                                value="<?php echo e(@$user->address->zip); ?>"
                                placeholder="<?php echo e(translate('Postal code', 'forms')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label"><?php echo e(translate('Country', 'forms')); ?> : </label>
                        <select name="country" class="form-select form-select-md radius radius-md">
                            <option value="">--</option>
                            <?php $__currentLoopData = countries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($country->id); ?>"
                                    <?php echo e($country->name == @$user->address->country ? 'selected' : ''); ?>>
                                    <?php echo e($country->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md radius radius-md"><?php echo e(translate('Save Changes', 'settings')); ?></button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.user.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/settings/index.blade.php ENDPATH**/ ?>