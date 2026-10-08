<?php if(settings('general')->adblock_detection == 1 && subscription()->plan->advertisements): ?>
    <script>
        "use strict";
        async function protection() {
            let adBlockEnabled = false
            const googleAdUrl = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'
            try {
                await fetch(new Request(googleAdUrl)).catch(_ => adBlockEnabled = true)
            } catch (e) {
                adBlockEnabled = true
            } finally {
                if (adBlockEnabled === true) {
                    document.body.classList.add('protection');
                    document.body.innerHTML +=
                        '<div class="protection"> <div class="protection-inner"> <div class="protection-icon"> <i class="fas fa-hand-paper"></i> </div> <h3 class="protection-title">' +
                        "<?php echo e(translate('Adblock Detected!')); ?>" +
                        '</h3> <p class="protection-text mb-3 h5">' +
                        " <?php echo e(translate('Please disable AdBlock to continue browsing')); ?>" +
                        '</p> <button onClick="window.location.reload();" class="btn btn-outline-light btn-md">' +
                        "<?php echo e(translate('Refresh')); ?>" + '</button> </div> </div>';
                }
            }
        }
        protection();
    </script>
<?php endif; ?>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/partials/adblock-full.blade.php ENDPATH**/ ?>