<?php $__env->startSection('title', translate('Settings', 'settings')); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('themes.basic.user.settings.includes.links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row g-3 mb-4">
        <div class="<?php echo e($withdrawalMethods->count() > 0 ? 'col-lg-6' : 'col-12'); ?>">
            <div class="card-v">
                <h5 class="mb-0"><?php echo e(translate('Withdrawal Details', 'settings')); ?></h5>
                <div class="form-section">
                    <form id="deatilsForm" action="<?php echo e(route('user.settings.withdrawal.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(translate('Withdrawal Method', 'settings')); ?> : </label>
                            <select id="withdrawalMethodSelect" name="withdrawal_method"
                                class="form-select form-select-md radius radius-md">
                                <option value="">--</option>
                                <?php $__currentLoopData = $withdrawalMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawalMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($withdrawalMethod->id); ?>"
                                        <?php echo e($withdrawalMethod->id == $user->withdrawal_method_id ? 'selected' : ''); ?>>
                                        <?php echo e($withdrawalMethod->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php $__currentLoopData = $withdrawalMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawalMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($withdrawalMethod->description): ?>
                                <div
                                    class="withdrawal-descriptions description-<?php echo e($withdrawalMethod->id); ?> 
                                    <?php echo e($user->withdrawal_method_id != $withdrawalMethod->id ? 'd-none' : ''); ?> mb-4">
                                    <?php echo $withdrawalMethod->description; ?>

                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <label class="form-label"><?php echo e(translate('Withdrawal Account', 'settings')); ?> : </label>
                            <textarea type="text" name="withdrawal_account" class="form-control radius radius-md" rows="4"><?php echo e($user->withdrawal_account); ?></textarea>
                        </div>
                        <button
                            class="btn btn-primary btn-md radius radius-md"><?php echo e(translate('Save Changes', 'settings')); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <?php if($withdrawalMethods->count() > 0): ?>
            <div class="col-lg-6">
                <div class="card-v">
                    <h5 class="mb-0"><?php echo e(translate('Withdrawal Methods', 'settings')); ?></h5>
                    <div class="form-section">
                        <div class="dash-table2">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th><?php echo e(translate('Withdrawal Method', 'settings')); ?></th>
                                        <th><?php echo e(translate('Minimum Amount', 'settings')); ?></th>
                                    </tr>
                                    <?php $__currentLoopData = $withdrawalMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawalMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($withdrawalMethod->name); ?></td>
                                            <td><?php echo e(priceSymbol($withdrawalMethod->minimum)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.user.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/settings/withdrawal.blade.php ENDPATH**/ ?>