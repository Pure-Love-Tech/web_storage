@extends('backend.layouts.form')
@section('title', admin_trans('New announcement'))
@section('container', 'container-max-lg')
@section('back', route('admin.announcements.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.announcements.store') }}" method="POST">
        @csrf
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Language') }}</label>
                        <select name="lang" class="form-select select2" required>
                            <option></option>
                            @foreach ($adminLanguages as $adminLanguage)
                                <option value="{{ $adminLanguage->code }}"
                                    @if (old('lang') == $adminLanguage->code) selected @endif>
                                    {{ $adminLanguage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Status') }} </label>
                        <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ admin_trans('Public') }}"
                            data-off="{{ admin_trans('Private') }}" checked>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required />
                </div>
                <div class="mb-2 ckeditor-md">
                    <label class="form-label">{{ admin_trans('Body') }}</label>
                    <textarea name="body" class="ckeditor">{{ old('body') }}</textarea>
                </div>
            </div>
        </div>
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
    @endpush
@endsection
