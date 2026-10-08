@extends('backend.layouts.form')
@section('title', $page->title)
@section('section', admin_trans('Settings'))
@section('back', route('admin.settings.pages.index'))
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary" href="{{ route('page', $page->slug) }}" target="_blank"><i
                class="fa fa-eye me-2"></i>{{ admin_trans('Preview') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.settings.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card p-2 h-100 mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Page title') }}</label>
                            <input type="text" name="title" class="form-control" required
                                value="{{ $page->title }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Slug') }}</label>
                            <div class="input-group vironeer-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ url('/') }}/</span>
                                </div>
                                <input type="text" name="slug" class="form-control" required
                                    value="{{ $page->slug }}" />
                            </div>
                        </div>
                        <div class="ckeditor-lg mb-3">
                            <label class="form-label">{{ admin_trans('Page content') }}</label>
                            <textarea name="content" rows="10" class="form-control ckeditor">{{ $page->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Language') }}</label>
                            <select name="lang" class="form-select select2" required>
                                <option></option>
                                @foreach ($adminLanguages as $adminLanguage)
                                    <option value="{{ $adminLanguage->code }}"
                                        @if ($page->lang == $adminLanguage->code) selected @endif>
                                        {{ $adminLanguage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Short description') }}</label>
                            <textarea name="short_description" rows="6" class="form-control"
                                placeholder="{{ admin_trans('50 to 200 character at most') }}" required>{{ $page->short_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
    @endpush
@endsection
