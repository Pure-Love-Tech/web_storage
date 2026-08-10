@extends('backend.layouts.form')
@section('section', admin_trans('Blog'))
@section('title', $article->title)
@section('back', route('admin.blog.articles.index'))
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary" href="{{ route('blog.article', $article->slug) }}" target="_blank"><i
                class="fa fa-eye me-2"></i>{{ admin_trans('Preview') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.blog.articles.update', $article->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card p-2 h-100 mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Article title') }}</label>
                            <input type="text" name="title" id="create_slug" class="form-control"
                                value="{{ $article->title }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Slug') }}</label>
                            <div class="input-group vironeer-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ url('blog/article/') }}/</span>
                                </div>
                                <input type="text" name="slug" class="form-control" value="{{ $article->slug }}"
                                    required />
                            </div>
                        </div>
                        <div class="ckeditor-lg mb-0">
                            <label class="form-label">{{ admin_trans('Article content') }}</label>
                            <textarea name="content" rows="10" class="form-control ckeditor">{{ $article->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-2 h-100 mb-3">
                    <div class="card-body">
                        <div class="vironeer-file-preview-box mb-3 bg-light p-5 text-center">
                            <div class="file-preview-box mb-3">
                                <img id="filePreview" src="{{ asset($article->image) }}" class="rounded-3 w-100"
                                    height="160px">
                            </div>
                            <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ admin_trans('Choose Image') }}</button>
                            <input id="selectedFileInput" type="file" name="image"
                                accept="image/png, image/jpg, image/jpeg" hidden>
                            <small class="text-muted d-block">{{ admin_trans('Allowed (PNG, JPG, JPEG)') }}</small>
                            <small
                                class="text-muted d-block">{{ admin_trans('Image will be resized into (1280x720)') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Language') }}</label>
                            <select id="articleLang" name="lang" class="form-select select2" required>
                                <option></option>
                                @foreach ($adminLanguages as $adminLanguage)
                                    <option value="{{ $adminLanguage->code }}"
                                        @if ($article->lang == $adminLanguage->code) selected @endif>
                                        {{ $adminLanguage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Article category') }}</label>
                            <select id="articleCategory" name="category" class="form-select" required>
                                <option value="" selected disabled>{{ admin_trans('Choose') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($article->category_id == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ admin_trans('Short description') }}</label>
                            <textarea name="short_description" rows="6" class="form-control"
                                placeholder="{{ admin_trans('50 to 200 character at most') }}" required>{{ $article->short_description }}</textarea>
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
