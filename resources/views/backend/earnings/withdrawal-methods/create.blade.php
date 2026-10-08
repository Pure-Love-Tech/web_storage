@extends('backend.layouts.form')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('New Withdrawal Method'))
@section('container', 'container-max-lg')
@section('back', route('admin.earnings.withdrawal-methods.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.earnings.withdrawal-methods.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="vironeer-file-preview-box mb-3 bg-light p-5 text-center">
                    <div class="file-preview-box mb-3 d-none">
                        <img id="filePreview" src="#" width="120">
                    </div>
                    <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                            class="fas fa-camera me-2"></i>{{ admin_trans('Choose logo') }}</button>
                    <input id="selectedFileInput" type="file" name="logo" accept=".png, .jpg, .jpeg, .svg" hidden
                        required>
                    <small class="text-muted d-block">{{ admin_trans('Allowed (PNG, JPG, JPEG, SVG)') }}</small>
                </div>
                <div class="row g-3 mb-3 align-items-center">
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Name') }}
                        </label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Status') }} </label>
                        <input type="checkbox" name="status" data-toggle="toggle" checked>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Minimum Withdrawal Amount') }} :
                    </label>
                    <div class="custom-input-group input-group">
                        <input type="text" name="minimum" class="form-control input-price" placeholder="0.00"
                            value="{{ old('minimum') }}">
                        <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                    </div>
                </div>
                <div class="mb-2 ckeditor-md">
                    <label class="form-label">{{ admin_trans('Description') }} :
                    </label>
                    <textarea name="description" class="ckeditor">{{ old('description') }}</textarea>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery.priceformat.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
    @endpush
@endsection
