@extends('backend.layouts.form')
@section('title', $navbarMenu->name)
@section('container', 'container-max-lg')
@section('back', route('admin.navbarMenu.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.navbarMenu.update', $navbarMenu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Language') }}</label>
                    <select name="lang" class="form-select select2" required>
                        <option value="" selected disabled>{{ admin_trans('Choose') }}</option>
                        @foreach ($adminLanguages as $adminLanguage)
                            <option value="{{ $adminLanguage->code }}"
                                {{ $navbarMenu->lang == $adminLanguage->code ? 'selected' : '' }}>
                                {{ $adminLanguage->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $navbarMenu->name }}" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ admin_trans('Link') }}</label>
                    <input type="link" name="link" class="form-control" placeholder="/"
                        value="{{ $navbarMenu->link }}" required>
                </div>
            </form>
        </div>
    </div>
    @include('backend.navigation.includes.pages')
@endsection
