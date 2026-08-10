@if (subscription()->plan->upload_status)
    <div class="uploadbox">
        <div class="overlay"></div>
        <div class="uploadbox-content">
            <div class="uploadbox-header">
                <p class="h5 mb-0">{{ translate('Upload Files', 'file system') }}</p>
                <div class="ms-auto d-flex align-items-center">
                    <a class="upload-more-btn me-3 dz-clickable fs-6 d-none" data-dz-click>
                        <i class="fas fa-upload"></i>
                        <span class="ms-1 d-none d-sm-inline small">{{ translate('Upload more', 'file system') }}</span>
                    </a>
                    <button type="button" class="btn-close ms-auto d-inline-block"></button>
                </div>
            </div>
            <div class="uploadbox-body">
                <div class="uploadbox-body-header">
                    <div class="ms-auto small">
                        <a class="link d-none" data-dz-reset><i
                                class="fas fa-redo me-1"></i>{{ translate('Reset', 'file system') }}</a>
                    </div>
                </div>
                <div class="uploadbox-body-content">
                    <div class="uploadbox-drag" data-dz-click>
                        <div class="uploadbox-drag-inner">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h3>{{ translate('Drag and drop your files or click here to upload', 'file system') }}</h3>
                            <p class="mb-0">
                                {{ translate('You can also', 'file system') }} <a
                                    class="link">{{ translate('browse files from your device', 'file system') }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="uploadbox-wrapper">
                        <div id="dropzone"
                            class="dropzone row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 justify-content-center g-3">
                        </div>
                        <div id="upload-previews">
                            <div class="dz-preview dz-file-preview col">
                                <div class="dz-preview-container">
                                    <div class="dz-details">
                                        <div class="dz-actions">
                                            <div class="row justify-content-between flex-nowrap">
                                                <div class="col-auto">
                                                    <a class="dz-edit me-2" data-dz-edit>
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                                <div class="col-auto">
                                                    <a class="dz-remove" data-dz-remove>
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <span data-dz-extension class="vi vi-file vi-2x"></span>
                                        </div>
                                        <div class="dz-name">
                                            <span data-dz-name></span>
                                        </div>
                                        <div class="dz-size"></div>
                                        <div class="dz-details-info">
                                            <div class="dz-success-mark">
                                                <span><i class="fas fa-check"></i></span>
                                            </div>
                                            <div class="dz-error-mark">
                                                <span><i class="fas fa-times"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dz-progress">
                                        <span class="dz-upload" data-dz-uploadprogress></span>
                                        <span class="dz-upload-precent"></span>
                                    </div>
                                    <div class="dz-file-edit">
                                        <div class="overlay"></div>
                                        <div class="dz-file-edit-box">
                                            <div class="dz-file-edit-box-header">
                                                <span
                                                    class="fs-5">{{ translate('Edit file details', 'file system') }}</span>
                                            </div>
                                            <div class="dz-file-edit-box-body">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ translate('Name', 'forms') }} : <span
                                                            class="required">*</span></label>
                                                    <input type="text" name="name"
                                                        class="form-control form-control-md radius radius-md" />
                                                </div>
                                                @auth
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ translate('Visibility', 'forms') }} :
                                                        </label>
                                                        <select name="visibility"
                                                            class="form-select form-select-md radius radius-md">
                                                            @foreach (\App\Models\FileEntry::getVisibilityOptions() as $visibilityOptionKey => $visibilityOptionValue)
                                                                <option value="{{ $visibilityOptionKey }}">
                                                                    {{ $visibilityOptionValue }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endauth
                                                <div class="mb-3">
                                                    <label class="form-label">{{ translate('Password', 'forms') }}
                                                        :</label>
                                                    <input type="text" name="password"
                                                        class="form-control form-control-md radius radius-md"
                                                        disabled />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">{{ translate('Description', 'forms') }}
                                                        :</label>
                                                    <textarea name="description" class="form-control radius radius-md" rows="3"></textarea>
                                                </div>
                                                <div>
                                                    <button
                                                        class="btn btn-primary btn-md radius radius-md">{{ translate('Done', 'file system') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uploadbox-wrapper-form mt-4">
                            @auth
                                <div class="mb-3">
                                    <label class="form-label fw-500">{{ translate('Folder', 'forms') }}</label>
                                    <select name="folder" class="form-select form-select-md radius radius-md">
                                        <option value="">/</option>
                                        @foreach ($folderOptions as $option)
                                            <option value="{{ $option['value'] }}" @selected(request('folder') == $option['value'])>
                                                {{ $option['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endauth
                            <div class="d-flex justify-content-center">
                                <button id="upload-files-btn"
                                    class="btn btn-secondary radius radius-md btn-md">{{ translate('Upload', 'file system') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/dropzone/dropzone.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
    @push('config')
        @include('themes.basic.partials.dropzone-options')
        @php
            $extensions = explode(',', $settings->filesystem->upload->types->extensions);
            $formattedExtensions = implode(
                ', ',
                array_map(function ($extension) {
                    return '.' . trim($extension);
                }, $extensions),
            );
        @endphp
        <script>
            "use strict";
            const uploadConfig = {!! json_encode([
                'subscription' => [
                    'is_expired' => subscription()->is_expired,
                ],
                'upload' => [
                    'max_files' => intval($settings->filesystem->upload->max_files),
                    'chunk_size' => $settings->filesystem->upload->chunk_size * 1024 * 1024,
                    'allowed_file_types' => $settings->filesystem->upload->types->status ? '' : $formattedExtensions,
                    'storage_space' => subscription()->storage->remaining->number,
                    'max_file_size' => subscription()->upload->max_file_size,
                ],
                'trans' => [
                    'format_bytes' => [
                        translate('B', 'file system'),
                        translate('KB', 'file system'),
                        translate('MB', 'file system'),
                        translate('GB', 'file system'),
                        translate('TB', 'file system'),
                    ],
                    'close_alert_msg' => translate('Are you sure you want to close this window?', 'file system'),
                    'errors' => [
                        'subscription_expired' => translate('Your subscription has expired', 'settings'),
                        'empty' => translate('No files attached', 'file system'),
                        'file_duplicate' => translate('You cannot attach the same file twice', 'file system'),
                        'file_empty' => translate('Empty files cannot be uploaded', 'file system'),
                        'file_name_empty' => translate('File name cannot be empty', 'file system'),
                        'storage_space_exceeded' => translate('Your storage space is not enough to upload the file', 'file system'),
                        'file_limit_exceeded' => str(
                            translate('File is too big, Max file size {max_file_size}', 'file system'),
                        )->replace('{max_file_size}', subscription()->formats->max_file_size),
                    ],
                    'view_file' => translate('View file', 'file system'),
                ],
            ]) !!};
        </script>
    @endpush
@endif
