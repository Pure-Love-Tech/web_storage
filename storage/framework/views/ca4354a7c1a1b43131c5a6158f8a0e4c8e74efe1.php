<?php $__env->startSection('section', admin_trans('Earnings')); ?>
<?php $__env->startSection('title', admin_trans('Earnings Settings')); ?>
<?php $__env->startSection('container', 'container-max-lg'); ?>
<?php $__env->startSection('content'); ?>
    <form id="vironeer-submited-form" action="<?php echo e(route('admin.earnings.settings')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card mb-3">
            <div class="card-header">
                <?php echo e(admin_trans('Downloads Earnings')); ?>

            </div>
            <div class="card-body">
                <div class="row g-2 align-items-center mb-4">
                    <div class="col-lg-3"><?php echo e(admin_trans('Status')); ?> :</div>
                    <div class="col-lg-3">
                        <input type="checkbox" name="earnings[downloads][status]" data-toggle="toggle"
                            class="option-checkbox" data-id="3" data-on="<?php echo e(admin_trans('Enable')); ?>"
                            data-off="<?php echo e(admin_trans('Disable')); ?>"
                            <?php echo e($settings->earnings->downloads->status ? 'checked' : ''); ?>>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3"><?php echo e(admin_trans('Store Paid downloads only')); ?> :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="earnings[downloads][store]" data-toggle="toggle"
                                    data-on="<?php echo e(admin_trans('Yes')); ?>" data-off="<?php echo e(admin_trans('No')); ?>"
                                    <?php echo e($settings->earnings->downloads->store ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-12  option-3 <?php echo e(!$settings->earnings->downloads->status ? 'd-none' : ''); ?>">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3"><?php echo e(admin_trans('Paid Downloads Per Day')); ?> :
                            </div>
                            <div class="col-lg-9">
                                <input type="number" name="earnings[downloads][paid]" class="form-control" min="1"
                                    max="1000" value="<?php echo e($settings->earnings->downloads->paid); ?>">
                                <div class="form-text">
                                    <?php echo e(admin_trans('The paid downloads per IP each day')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <?php echo e(admin_trans('Referrals Earnings')); ?>

            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3"><?php echo e(admin_trans('Status')); ?> :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="earnings[referrals][status]" data-toggle="toggle"
                                    class="option-checkbox" data-id="4" data-on="<?php echo e(admin_trans('Enable')); ?>"
                                    data-off="<?php echo e(admin_trans('Disable')); ?>"
                                    <?php echo e($settings->earnings->referrals->status ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 option-4 <?php echo e(!$settings->earnings->referrals->status ? 'd-none' : ''); ?>">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3"><?php echo e(admin_trans('Referral Earnings Percentage')); ?> :
                            </div>
                            <div class="col-lg-9">
                                <div class="custom-input-group input-group">
                                    <input type="number" name="earnings[referrals][percentage]" class="form-control"
                                        min="1" max="100"
                                        value="<?php echo e($settings->earnings->referrals->percentage); ?>">
                                    <span class="input-group-text"><strong><i class="fas fa-percent"></i></strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <?php echo e(admin_trans('Bonus')); ?>

            </div>
            <div class="card-body">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-3"><?php echo e(admin_trans('New users bonus')); ?> :
                    </div>
                    <div class="col-lg-9">
                        <div class="custom-input-group input-group">
                            <input type="number" name="earnings[bonus][users]" class="form-control"
                                value="<?php echo e($settings->earnings->bonus->users); ?>" step="any">
                            <span class="input-group-text"><strong><?php echo e($settings->currency->code); ?></strong></span>
                        </div>
                        <div class="form-text">
                            <?php echo e(admin_trans('The new users will get the bonus after registring, the bonus will be added to the user downloads earnings.')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <?php echo e(admin_trans('Security')); ?>

            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3"><?php echo e(admin_trans('Proxy/VPN Detection')); ?> :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="earnings[security][proxy_vpn_detection]" data-toggle="toggle"
                                    data-on="<?php echo e(admin_trans('Enable')); ?>" data-off="<?php echo e(admin_trans('Disable')); ?>"
                                    class="option-checkbox" data-id="1"
                                    <?php echo e($settings->earnings->security->proxy_vpn_detection ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 option-1 <?php echo e(!$settings->earnings->security->proxy_vpn_detection ? 'd-none' : ''); ?>">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">
                                <?php echo e(admin_trans('API Key')); ?> (<a href="https://trustip.io"
                                    target="_blank"><strong>Trustip.io</strong></a>) :</div>
                            <div class="col-lg-9">
                                <input type="text" name="earnings[security][trustip_api_key]" class="form-control"
                                    placeholder="<?php echo e(admin_trans('Enter trustip api key')); ?>"
                                    value="<?php echo e(demoMode() ? '' : $settings->earnings->security->trustip_api_key); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="row g-2">
                            <div class="col-lg-3">
                                <div class="mb-1"><?php echo e(admin_trans('Block Earnings for specific referrers')); ?> :</div>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="earnings[security][blocked_referrers]" class="form-control"
                                    placeholder="<?php echo e(admin_trans('example.com,example.com,example.com')); ?>" rows="4"><?php echo e($settings->earnings->security->blocked_referrers); ?></textarea>
                                <div class="form-text">
                                    <?php echo e(admin_trans('Enter the domains host only like "example.com" without any spaces and add commas between them.')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/backend/earnings/settings.blade.php ENDPATH**/ ?>