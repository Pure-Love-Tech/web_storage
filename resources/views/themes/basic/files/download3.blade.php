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
                        <x-ad alias="download_page_3_top" @class('ad-970x250 mb-4') />
                        <div class="file-card">
                            <div class="file-details">
                                <x-ad alias="download_page_3_center_top" @class('ad-970x250 mb-4') />
                                <div class="row g-4 text-center">
                                    <div class="col-12 col-xl-7 mx-auto download-section-box">
                                        <div class="download-file-link my-4">
                                            @if ($downloadPlan->download_waiting_time > 0)
                                                <h3 class="mb-4">
                                                    {{ translate('We are generating your download link', 'download pages') }}
                                                </h3>
                                                <p
                                                    class="download-file-timer d-flex align-items-center justify-content-center text-center mb-4">
                                                    {!! str(translate('Please wait {seconds} Seconds', 'download pages'))->replace(
                                                        '{seconds}',
                                                        '<span class="h4 mx-2 text-secondary mb-0">' . $downloadPlan->download_waiting_time . '</span>',
                                                    ) !!}
                                                </p>
                                            @endif
                                            <a href="#"
                                                class="btn {{ $method == 'free' ? 'btn-secondary' : 'btn-primary' }} btn-md fw-500 disabled">
                                                <i class="fa-solid fa-download me-1"></i>
                                                {{ translate('Click Here to Download', 'download pages') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <x-ad alias="download_page_3_center_bottom" @class('ad-970x250 mt-4') />
                                @if ($themeSettings->download_pages->file_about)
                                    @include('themes.basic.files.common.about', [
                                        'fileEntry' => $fileEntry,
                                    ])
                                @endif
                            </div>
                        </div>
                        <x-ad alias="download_page_3_bottom" @class('ad-970x250 mt-5') />
                        @if ($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page3_extra_text)
                            <div class="file-card mt-5">
                                {!! $themeSettings->download_pages->page3_extra_text !!}
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
