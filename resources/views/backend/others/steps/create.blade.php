@extends('backend.layouts.form')
@section('title', admin_trans('Create New Step'))
@section('back', route('admin.steps.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.steps.store') }}" method="POST">
        @csrf
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Language') }}</label>
                    <select id="articleLang" name="lang" class="form-select select2" required>
                        <option></option>
                        @foreach ($adminLanguages as $adminLanguage)
                            <option value="{{ $adminLanguage->code }}"
                                {{ old('lang') == $adminLanguage->code ? 'selected' : '' }}>
                                {{ $adminLanguage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required
                        autofocus />
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ admin_trans('Body') }}</label>
                    <textarea name="body" rows="10" class="form-control" placeholder="{{ admin_trans('Max 600 characters') }}"
                        required>{{ old('body') }}</textarea>
                </div>
            </div>
        </div>
    </form>
@endsection
