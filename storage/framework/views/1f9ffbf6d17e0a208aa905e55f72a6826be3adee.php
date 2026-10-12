<div wire:ignore.self wire:key="shareModal" class="modal custom-modal share-modal fade" id="shareModal" tabindex="-1"
    aria-labelledby="shareModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel"><i
                        class="fa-solid fa-share-nodes me-2"></i><?php echo e(translate('Share', 'files')); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if($fileEntry): ?>
                    <?php if($fileEntry->isPrivate()): ?>
                        <div class="alert alert-danger mb-0">
                            <i class="fa-regular fa-circle-question me-1"></i>
                            <span><?php echo e(translate('Private files or folders cannot be shared, change the visibility to public before sharing.', 'files')); ?></span>
                        </div>
                    <?php else: ?>
                        <div class="file-details">
                            <div class="file-icon mb-2">
                                <?php echo $fileEntry->getFileIcon($fileEntry->isFolder() ? 'fa-2x' : 'vi-sm'); ?>

                            </div>
                            <p><?php echo e(shorterText($fileEntry->name, 35)); ?></p>
                        </div>
                        <div class="socials v2 mt-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($fileEntry->sharedLink()); ?>"
                                class="social-btn social-facebook" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo e($fileEntry->sharedLink()); ?>"
                                class="social-btn social-twitter" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo e($fileEntry->sharedLink()); ?>"
                                class="social-btn social-linkedin" target="_blank">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text=<?php echo e($fileEntry->sharedLink()); ?>"
                                class="social-btn social-whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="http://pinterest.com/pin/create/button/?url=<?php echo e($fileEntry->sharedLink()); ?>"
                                class="social-btn social-pinterest" target="_blank">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                        <div class="mt-4">
                            <div class="input-group">
                                <input id="sharedLink" type="text"
                                    class="form-control form-control-md radius radius-md"
                                    value="<?php echo e($fileEntry->sharedLink()); ?>" readonly>
                                <button type="button" class="btn btn-secondary btn-md radius radius-md btn-copy"
                                    data-clipboard-target="#sharedLink">
                                    <i class="far fa-clone me-2"></i><?php echo e(translate('Copy', 'files')); ?>

                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/livewire/files/share-modal.blade.php ENDPATH**/ ?>