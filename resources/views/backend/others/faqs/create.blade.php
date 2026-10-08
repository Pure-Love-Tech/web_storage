@extends('backend.layouts.form')
@section('title', admin_trans('Create a Faq'))
@section('container', 'container-max-lg')
@section('back', route('admin.faqs.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Language') }}</label>
                    <select name="lang" class="form-select select2" required>
                        <option></option>
                        @foreach ($adminLanguages as $adminLanguage)
                            <option value="{{ $adminLanguage->code }}" @if (old('lang') == $adminLanguage->code) selected @endif>
                                {{ $adminLanguage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required />
                </div>
                <div class="mb-2">
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
