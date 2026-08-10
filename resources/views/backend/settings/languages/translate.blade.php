@extends('backend.layouts.form')
@section('title', activeTheme() . ' ' . admin_trans('theme') . ' ' . $language->name . ' ' . 'translates')
@section('section', admin_trans('Settings'))
@section('back', route('admin.settings.languages.index'))
@section('content')
    <div class="note note-warning d-flex">
        <div class="icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div>
            <strong>{{ admin_trans('Important!') }}</strong>
            <li>
                <small>{{ admin_trans('Translates may not take effect immediately, you may need to refresh the page multiple times or clear the cache.') }}</small>
            </li>
            <li><small>{{ admin_trans('There are some words that should not be translated that start with some tags or are inside a tag') }}
                    <strong>{{ admin_trans(':value, :seconds, :min, ::max, {username},') }}</strong>
                    {{ admin_trans('etc...') }}</small></li>
        </div>
    </div>
    <div class="mb-3">
        <form class="d-inline" action="{{ route('admin.settings.languages.translates.export', $language->code) }}"
            method="POST">
            @csrf
            <button class="btn btn-success btn-lg me-2"><i
                    class="fas fa-download me-2"></i>{{ admin_trans('Export') }}</button>
        </form>
        <button class="btn btn-blue btn-lg" data-bs-toggle="modal" data-bs-target="#importModal"><i
                class="fas fa-upload me-2"></i>{{ admin_trans('Import') }}</button>
    </div>
    <div class="card translate-card">
        <div class="card-header">
            <ul class="nav nav-pills card-header-tabs">
                @foreach ($groups as $group)
                    <li class="nav-item">
                        <a class="nav-link {{ $active == $group ? 'active' : '' }}"
                            href="{{ route('admin.settings.languages.translates.group', [$language->code, $group]) }}">{{ str_replace('-', ' ', $group) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body my-1">
            <form id="vironeer-submited-form"
                action="{{ route('admin.settings.languages.translates.update', $language->id) }}" method="POST">
                @csrf
                <input type="hidden" name="group" value="{{ $active }}">
                @if (is_array($translates) && count($translates) > 0)
                    @foreach ($translates as $key1 => $value1)
                        @if (is_array($value1))
                            <h2 class="header">{{ $key1 }}</h2>
                            @foreach ($value1 as $key2 => $value2)
                                <div class="vironeer-translate-box">
                                    <label
                                        class="form-label text-muted">{{ ucfirst(str_replace('_', ' ', $key1)) }}</label>
                                    <div class="vironeer-translated-item d-block d-lg-flex bd-highlight align-items-center">
                                        <div class="flex-grow-1 bd-highlight">
                                            <textarea id="autosizeInput" class="vironeer-translate-key translate-fields form-control" rows="1" readonly>{{ $defaultLanguage[$key1][$key2] }}</textarea>
                                        </div>
                                        <div class="pe-3 ps-3 bd-highlight text-center text-success d-none d-lg-block"><i
                                                class="fas fa-chevron-right"></i></div>
                                        <div class="flex-grow-1 bd-highlight">
                                            <textarea id="autosizeInput" name="translates[{{ $key1 }}][{{ $key2 }}]"
                                                class="translate-fields form-control" rows="1" placeholder="{{ $value2 }}">{{ $value2 }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="vironeer-translate-box">
                                <label class="form-label text-muted">{{ ucfirst(str_replace('_', ' ', $key1)) }}</label>
                                <div class="vironeer-translated-item d-block d-lg-flex bd-highlight align-items-center">
                                    <div class="flex-grow-1 bd-highlight">
                                        <textarea id="autosizeInput" class="vironeer-translate-key translate-fields form-control" rows="1" readonly>{{ $defaultLanguage[$key1] }}</textarea>
                                    </div>
                                    <div class="pe-3 ps-3 bd-highlight text-center text-success d-none d-lg-block"><i
                                            class="fas fa-chevron-right"></i></div>
                                    <div class="flex-grow-1 bd-highlight">
                                        <textarea id="autosizeInput" name="translates[{{ $key1 }}]" class="translate-fields form-control"
                                            rows="1" placeholder="{{ $value1 }}">{{ $value1 }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center">
                        <p class="mb-0 text-muted">{{ admin_trans('No translations found') }}</p>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="importModalLabel">
                        {{ $language->name }}
                        <i class="fas fa-angle-right ms-1 me-1"></i>
                        {{ admin_trans('Import') }}
                    </h5>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.settings.languages.translates.import', $language->code) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="note note-warning">
                            <h5 class="mb-2"><strong>{{ admin_trans('Important!') }}</strong></h5>
                            <ul class="mb-0">
                                <li class="mb-1">
                                    {{ admin_trans('Make sure you are uploading the active theme translations.') }}
                                </li>
                                <li class="mb-1">
                                    {{ admin_trans('The existing translations will be permanently deleted, make sure to take a backup before importing the new translations.') }}
                                </li>
                                <li class="mb-0">
                                    {{ admin_trans('Uploading files other than translations exported may cause errors on your site, make sure you are importing the correct files.') }}
                                </li>
                            </ul>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ admin_trans('Language File (ZIP)') }} </label>
                            <input type="file" name="language_file" class="form-control form-control-lg">
                        </div>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-secondary btn-lg w-100" data-bs-dismiss="modal"
                                    aria-label="Close">{{ admin_trans('Close') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button class="btn btn-dark btn-lg w-100">{{ admin_trans('Import') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/autosize/autosize.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            autosize($('textarea'));
        </script>
    @endpush
@endsection
