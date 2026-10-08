@extends('backend.layouts.form')
@section('title', admin_trans('Add language'))
@section('section', admin_trans('Settings'))
@section('container', 'container-max-lg')
@section('back', route('admin.settings.languages.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.languages.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                    <div class="file-preview-box mb-3 d-none">
                        <img id="filePreview" src="#" class="rounded-3" width="25" height="25">
                    </div>
                    <button id="selectFileBtn" type="button"
                        class="btn btn-secondary mb-2">{{ admin_trans('Choose Flag') }}</button>
                    <input id="selectedFileInput" type="file" name="flag" accept="image/png, image/jpg, image/jpeg"
                        hidden required>
                    <small class="text-muted d-block">{{ admin_trans('Allowed (PNG, JPG, JPEG)') }}</small>
                    <small class="text-muted d-block">{{ admin_trans('Image will be resized into (25x25)') }}</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-lg-12">
                        <label class="form-label">{{ admin_trans('Name') }}</label>
                        <input type="text" name="name" class="form-control" required autofocus>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ admin_trans('Code') }}</label>
                        <select name="code" class="form-select select2" required>
                            <option></option>
                            @foreach (\App\Models\Language::options() as $code => $name)
                                <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-0 form-check">
                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default">
                    <label class="form-check-label" for="is_default">{{ admin_trans('Default language') }}</label>
                </div>
            </div>
        </div>
    </form>
@endsection
