@extends('backend.layouts.form')
@section('title', $feature->title)
@section('back', route('admin.features.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.features.update', $feature->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="vironeer-file-preview-box mb-3 bg-light p-5 text-center">
                    <div class="file-preview-box mb-3">
                        <img id="filePreview" src="{{ asset($feature->image) }}" class="rounded-3 w-100" height="80px"
                            height="80px">
                    </div>
                    <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                            class="fas fa-camera me-2"></i>{{ admin_trans('Choose Image') }}</button>
                    <input id="selectedFileInput" type="file" name="image" accept=".png, .jpg, .jpeg, .svg" hidden>
                    <small class="text-muted d-block">{{ admin_trans('Allowed (PNG, JPG, JPEG, SVG)') }}</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Language') }}</label>
                    <select id="articleLang" name="lang" class="form-select select2" required>
                        <option></option>
                        @foreach ($adminLanguages as $adminLanguage)
                            <option value="{{ $adminLanguage->code }}"
                                {{ $feature->lang == $adminLanguage->code ? 'selected' : '' }}>
                                {{ $adminLanguage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ $feature->title }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Body') }}</label>
                    <textarea name="body" rows="10" class="form-control" placeholder="{{ admin_trans('Max 600 characters') }}"
                        required>{{ $feature->body }}</textarea>
                </div>
            </div>
        </div>
    </form>
@endsection
