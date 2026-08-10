@extends('themes.basic.layouts.single')
@section('section', translate('Download', 'download pages'))
@section('title', $fileEntry->name)
@section('hide_header', true)
@section('content')
    <div class="section download-section">
        <div class="container">
            <div class="section-inner">
                <div class="custom-container">
                    <div class="section-body">
                        @include('themes.basic.files.common.title', [
                            'fileEntry' => $fileEntry,
                        ])
                        <x-ad alias="download_page_2_top" @class('ad-970x250 mb-4') />
                        <div class="file-card">
                            <div class="file-details">
                                <x-ad alias="download_page_2_center_top" @class('ad-970x250 mb-4') />
                                <div class="row g-4 text-center">
                                    <div class="col-12 col-xl-7 mx-auto download-section-box">
                                        <form id="down_2Form" action="{{ route('files.file', $fileEntry->sharedId()) }}"
                                            method="POST">
                                            <div class="d-flex flex-column align-items-center">
                                                @if ($settings->general->default_captcha && $downloadPlan->download_captcha)
                                                    <div class="mb-3">
                                                        @php
                                                            $callback = ['data-callback' => 'recaptchaCallback'];
                                                        @endphp
                                                        <x-captcha :callback="$callback" />
                                                    </div>
                                                @endif
                                                <input type="hidden" name="p" value="down_2">
                                                <input type="hidden" name="method" value="{{ $method }}">
                                                @csrf
                                                <button
                                                    class="btn {{ $method == 'free' ? 'btn-secondary' : 'btn-primary' }} btn-md fw-500"
                                                    disabled>
                                                    {{ translate('Create Download Link', 'download pages') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <x-ad alias="download_page_2_center_bottom" @class('ad-970x250 mt-4') />
                                @if ($themeSettings->download_pages->file_about)
                                    @include('themes.basic.files.common.about', [
                                        'fileEntry' => $fileEntry,
                                    ])
                                @endif
                            </div>
                        </div>
                        <x-ad alias="download_page_2_bottom" @class('ad-970x250 mt-5') />
                        @if ($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page2_extra_text)
                            <div class="file-card mt-5">
                                {!! $themeSettings->download_pages->page2_extra_text !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('config')
        @include('themes.basic.files.common.config', [
            'fileEntry' => $fileEntry,
            'downloadPlan' => $downloadPlan,
        ])
    @endpush
@endsection
