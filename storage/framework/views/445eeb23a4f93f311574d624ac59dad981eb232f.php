<?php $__env->startSection('title', translate('Payment Proof', 'payment proof')); ?>
<?php $__env->startSection('content'); ?>
    <div class="section section-start">
        
        <div class="container">
            <div class="custom-container">
                <div class="section-inner">
                    <div class="section-body">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 justify-content-center g-3 mb-4">
                            <div class="col">
                                <div class="counter counter-gradient">
                                    <div class="card-v">
                                        <div class="counter-info">
                                            <h5 class="counter-title"><?php echo e(translate('Total Requests', 'payment proof')); ?>

                                            </h5>
                                            <p class="counter-number"><?php echo e($counters['total_requests']); ?></p>
                                        </div>
                                        <div class="counter-icon">
                                            <i class="fa-solid fa-money-bill-transfer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="counter counter-gradient">
                                    <div class="card-v">
                                        <div class="counter-info">
                                            <h5 class="counter-title"><?php echo e(translate('Total Paid Amount', 'payment proof')); ?>

                                            </h5>
                                            <p class="counter-number"><?php echo e(earnings($counters['total_paid_amount'])); ?></p>
                                        </div>
                                        <div class="counter-icon">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payout-table">
                            <div class="card-v p-0">
                                <?php if($withdrawals->count() > 0): ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-start"><?php echo e(translate('Date', 'payment proof')); ?></th>
                                                <th><?php echo e(translate('Username', 'payment proof')); ?></th>
                                                <th><?php echo e(translate('Amount', 'payment proof')); ?></th>
                                                <th class="text-end"><?php echo e(translate('Method', 'payment proof')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-muted">
                                            <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="text-start"><?php echo e(dateFormat($withdrawal->created_at)); ?></td>
                                                    <td><?php echo e($withdrawal->user->usernameMasked()); ?></td>
                                                    <td class="text-success">
                                                        <strong><?php echo e(earnings($withdrawal->total)); ?></strong>
                                                    </td>
                                                    <td class="text-end"><?php echo e($withdrawal->method); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="card-body p-4">
                                        <div class="text-center text-muted">
                                            <?php echo e(translate('No payment proofs available', 'payment proof')); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php echo e($withdrawals->links()); ?>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.layouts.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/payment-proof.blade.php ENDPATH**/ ?>