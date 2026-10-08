@extends('backend.layouts.form')
@section('section', admin_trans('Themes'))
@section('title', $theme->name . ' ' . admin_trans('theme custom css'))
@section('back', route('admin.appearance.themes.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.appearance.themes.custom-css.update', $theme->id) }}"
        method="POST">
        @csrf
        <textarea name="custom_css" id="css-editor" class="form-control">{{ $themeCustomCssFile }}</textarea>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/css.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection
