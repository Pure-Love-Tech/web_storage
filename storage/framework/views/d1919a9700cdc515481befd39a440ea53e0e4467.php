<?php
    $directFileToBig = translate('file is too big max file size: {{ maxFilesize }}MiB.', 'file system');
    $dictResponseError = translate('Server responded with {{ statusCode }} code.', 'file system');
?>
<script>
    "use strict";
    const dropzoneOptions = {
        dictDefaultMessage: "<?php echo e(translate('Drop files here to upload', 'file system')); ?>",
        dictFallbackMessage: "<?php echo e(translate('Your browser does not support drag and drop file uploads.', 'file system')); ?>",
        dictFallbackText: "<?php echo e(translate('Please use the fallback form below to upload your files like in the olden days.', 'file system')); ?>",
        dictFileTooBig: "<?php echo e($directFileToBig); ?>",
        dictInvalidFileType: "<?php echo e(translate('You cannot upload files of this type.', 'file system')); ?>",
        dictResponseError: "<?php echo e($dictResponseError); ?>",
        dictCancelUpload: "<?php echo e(translate('Cancel upload', 'file system')); ?>",
        dictCancelUploadConfirmation: "<?php echo e(translate('Are you sure you want to cancel this upload?', 'file system')); ?>",
        dictRemoveFile: "<?php echo e(translate('Remove file', 'file system')); ?>",
        dictMaxFilesExceeded: "<?php echo e(translate('You can not upload any more files.', 'file system')); ?>",
    };
</script>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/partials/dropzone-options.blade.php ENDPATH**/ ?>