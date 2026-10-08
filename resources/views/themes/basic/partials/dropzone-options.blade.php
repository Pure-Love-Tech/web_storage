@php
    $directFileToBig = translate('file is too big max file size: {{ maxFilesize }}MiB.', 'file system');
    $dictResponseError = translate('Server responded with {{ statusCode }} code.', 'file system');
@endphp
<script>
    "use strict";
    const dropzoneOptions = {
        dictDefaultMessage: "{{ translate('Drop files here to upload', 'file system') }}",
        dictFallbackMessage: "{{ translate('Your browser does not support drag and drop file uploads.', 'file system') }}",
        dictFallbackText: "{{ translate('Please use the fallback form below to upload your files like in the olden days.', 'file system') }}",
        dictFileTooBig: "{{ $directFileToBig }}",
        dictInvalidFileType: "{{ translate('You cannot upload files of this type.', 'file system') }}",
        dictResponseError: "{{ $dictResponseError }}",
        dictCancelUpload: "{{ translate('Cancel upload', 'file system') }}",
        dictCancelUploadConfirmation: "{{ translate('Are you sure you want to cancel this upload?', 'file system') }}",
        dictRemoveFile: "{{ translate('Remove file', 'file system') }}",
        dictMaxFilesExceeded: "{{ translate('You can not upload any more files.', 'file system') }}",
    };
</script>
