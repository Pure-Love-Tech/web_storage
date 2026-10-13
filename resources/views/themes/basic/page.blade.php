@extends('themes.basic.layouts.single')
@section('body_class', 'arah-public arah-cms')
@section('title', $page->title)
@section('description', $page->short_description)
@section('content')
    <div class="section section-start" style="padding-top: unset">
        {{-- <x-ad alias="other_pages_top" @class('ad-728x90 mb-5') /> --}}
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    {{-- <h2 class="section-title text-capitalize mb-0">{{ $page->title }}</h2> --}}
                </div>
                <div class="arah-document-tools" role="search" aria-label="{{ translate('Search this page', 'pages') }}">
                    <label for="arah-document-search" class="arah-document-search-label">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        {{ translate('Search this page', 'pages') }}
                    </label>
                    <div class="arah-document-search-row">
                        <div class="arah-document-search-field">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                            <input type="search" id="arah-document-search" data-legal-search
                                placeholder="{{ translate('Search for a word or phrase', 'pages') }}"
                                autocomplete="off" aria-controls="arah-document-content">
                            <button type="button" data-legal-clear class="arah-document-search-clear"
                                aria-label="{{ translate('Clear search', 'pages') }}" hidden>
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="arah-document-search-navigation" data-legal-navigation hidden>
                            <span class="arah-document-search-count" data-legal-count role="status" aria-live="polite"
                                data-no-match="{{ translate('No matches', 'pages') }}"></span>
                            <button type="button" data-legal-prev disabled aria-label="{{ translate('Previous match', 'pages') }}">
                                <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
                            </button>
                            <button type="button" data-legal-next disabled aria-label="{{ translate('Next match', 'pages') }}">
                                <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="section-body arah-document-content" id="arah-document-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
        {{-- <x-ad alias="other_pages_bottom" @class('ad-728x90 mt-5') /> --}}
    </div>
    @push('scripts')
        <script defer src="{{ asset('themes/basic/assets/js/arah-legal-search.js') }}?v={{ filemtime(public_path('themes/basic/assets/js/arah-legal-search.js')) }}"></script>
    @endpush
@endsection
