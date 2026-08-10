@extends('backend.layouts.form')
@section('section', admin_trans('Settings'))
@section('title', admin_trans('File System'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.filesystem.update') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Upload Settings') }}
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Allow All file types') }} :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="filesystem[upload][types][status]" data-toggle="toggle"
                                    class="option-checkbox2" data-id="1" data-on="{{ admin_trans('Yes') }}"
                                    data-off="{{ admin_trans('No') }}"
                                    {{ $settings->filesystem->upload->types->status ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 option-1 {{ $settings->filesystem->upload->types->status ? 'd-none' : '' }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Enter the file types') }} :</div>
                            <div class="col-lg-9">
                                <input type="text" name="filesystem[upload][types][extensions]"
                                    class="tagsInput form-control" placeholder="{{ admin_trans('Enter the file types') }}"
                                    value="{{ $settings->filesystem->upload->types->extensions }}">
                                <div class="form-text">
                                    {{ admin_trans('The file types that you want to allow to be uploaded.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Chunk size') }}
                            </div>
                            <div class="col-lg-9">
                                <div class="custom-input-group input-group">
                                    <input type="number" name="filesystem[upload][chunk_size]" class="form-control"
                                        placeholder="10" value="{{ $settings->filesystem->upload->chunk_size }}"
                                        min="1" required>
                                    <span class="input-group-text"><i
                                            class="fas fa-hdd me-2"></i><strong>{{ admin_trans('MB') }}</strong></span>
                                </div>
                                <div class="form-text">
                                    {{ admin_trans('The size of the part that is sent in each request (90MB recommend).') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Max files at once') }}
                            </div>
                            <div class="col-lg-9">
                                <input type="number" name="filesystem[upload][max_files]" class="form-control"
                                    placeholder="0" value="{{ $settings->filesystem->upload->max_files }}" min="1"
                                    required>
                                <div class="form-text">
                                    {{ admin_trans('The maximum number of files that can be uploaded at one time.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Download Settings') }}
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Generated Links expiry time') }}</div>
                            <div class="col-lg-9">
                                <div class="custom-input-group input-group">
                                    <input type="number" name="filesystem[download][links_expiration_time]"
                                        class="form-control" min="5" placeholder="1"
                                        value="{{ $settings->filesystem->download->links_expiration_time }}" required>
                                    <span class="input-group-text"><i
                                            class="far fa-clock me-2"></i><strong>{{ admin_trans('Minutes') }}</strong></span>
                                </div>
                                <div class="form-text">
                                    {{ admin_trans('On the download page, a special link is generated for each download, Enter the expiration time of the links.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Download Links prefix') }}
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="filesystem[download][download_links_prefix]"
                                    class="form-control" min="5" placeholder="1"
                                    value="{{ $settings->filesystem->download->download_links_prefix }}" required>
                                <div class="form-text">
                                    {{ admin_trans('The download links prefix, for example "download". only letters, numbers, dashes and underscores are allowed') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                {{ admin_trans('Others') }}
            </div>
            <div class="card-body">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-3">{{ admin_trans('Default Folders') }} :</div>
                    <div class="col-lg-9">
                        <input type="text" name="filesystem[others][default_folders]" class="tagsInput form-control"
                            placeholder="{{ admin_trans('Enter the folder names') }}"
                            value="{{ $settings->filesystem->others->default_folders }}">
                        <div class="form-text">
                            {{ admin_trans('Leave the field blank to disable the creation of default folders.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        @push('styles_libs')
            <link rel="stylesheet" href="{{ asset('vendor/libs/tags-input/bootstrap-tagsinput.css') }}">
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/tags-input/bootstrap-tagsinput.min.js') }}"></script>
        @endpush
        <script>
            $(function() {
                let tagsInput = $('.tagsInput');
                tagsInput.tagsinput({
                    cancelConfirmKeysOnEmpty: false
                });
                tagsInput.on('beforeItemAdd', function(event) {
                    if (!/^[a-zA-Z-0-9_,]+$/.test(event.item)) {
                        event.cancel = true;
                        toastr.error(
                            "{{ admin_trans('Only letters, numbers, dashes and underscores are allowed.') }}"
                        );
                    }
                });
            });
        </script>
    @endpush
@endsection
