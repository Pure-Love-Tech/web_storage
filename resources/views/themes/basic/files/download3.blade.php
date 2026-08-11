@extends('themes.basic.layouts.single')
@section('section', translate('Download', 'download pages'))
@section('title', $fileEntry->name)
@section('hide_header', true)

@section('content')
    <style>
        .download-file-info {
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            padding: 20px;
            background: var(--bs-body-bg);
        }

        .download-file-info-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .download-file-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bs-secondary-bg);
            font-size: 22px;
        }

        .download-file-name h5 {
            font-weight: 600;
            margin: 0;
        }

        .download-file-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--bs-border-color);
        }

        .download-meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .download-meta-label {
            font-size: 13px;
            color: var(--bs-secondary-color);
        }

        .download-meta-item strong {
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 767px) {
            .download-file-meta {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }
    </style>
    <div class="section download-section">
        <div class="container">
            <div class="section-inner">
                <div class="custom-container">
                    <div class="section-body"> @include('themes.basic.files.common.title', ['fileEntry' => $fileEntry]) <x-ad alias="download_page_3_top"
                            @class('ad-970x250 mb-4') />
                        <div class="file-card">
                            <div class="file-details"> <x-ad alias="download_page_3_center_top"
                                    @class('ad-970x250 mb-4') /> {{-- File Metadata --}} <div
                                    class="download-file-info mb-4">
                                    <div class="download-file-header">
                                        <div class="download-file-icon"> {!! $fileEntry->getFileIcon('') !!} </div>
                                        <div class="download-file-title">
                                            <h5 class="mb-1 text-break"> {{ $fileEntry->getFullName() }} </h5> <span
                                                class="text-muted"> {{ translate('File information', 'download pages') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="download-file-meta"> {{-- File Size --}} <div class="download-meta-item">
                                            <div class="download-meta-label"> <i
                                                    class="fa-solid fa-weight-hanging me-1"></i>
                                                {{ translate('File Size', 'download pages') }} </div>
                                            <div class="download-meta-value"> {{ formatBytes($fileEntry->size) }} </div>
                                        </div> {{-- File Type --}} <div class="download-meta-item">
                                            <div class="download-meta-label"> <i class="fa-solid fa-file-lines me-1"></i>
                                                {{ translate('File Type', 'download pages') }} </div>
                                            <div class="download-meta-value">
                                                {{ strtoupper($fileEntry->extension ?: 'FILE') }} </div>
                                        </div> {{-- MIME Type --}} @if ($fileEntry->mime)
                                            <div class="download-meta-item">
                                                <div class="download-meta-label"> <i class="fa-solid fa-code me-1"></i>
                                                    {{ translate('Format', 'download pages') }} </div>
                                                <div class="download-meta-value text-break"> {{ $fileEntry->mime }} </div>
                                            </div>
                                            @endif {{-- Downloads --}} <div class="download-meta-item">
                                                <div class="download-meta-label"> <i class="fa-solid fa-download me-1"></i>
                                                    {{ translate('Downloads', 'download pages') }} </div>
                                                <div class="download-meta-value"> {{ number_format($fileEntry->downloads) }}
                                                </div>
                                            </div> {{-- Uploaded --}} <div class="download-meta-item">
                                                <div class="download-meta-label"> <i
                                                        class="fa-regular fa-calendar me-1"></i>
                                                    {{ translate('Uploaded', 'download pages') }} </div>
                                                <div class="download-meta-value">
                                                    {{ $fileEntry->created_at->format('d M Y') }} </div>
                                            </div> {{-- Expiry --}} @if ($fileEntry->expiry_at)
                                                <div class="download-meta-item">
                                                    <div class="download-meta-label"> <i
                                                            class="fa-regular fa-clock me-1"></i>
                                                        {{ translate('Available Until', 'download pages') }} </div>
                                                    <div class="download-meta-value">
                                                        {{ $fileEntry->expiry_at->format('d M Y') }} </div>
                                                </div>
                                                @endif </div>
                                </div> {{-- Download Section --}} <div class="row g-4 text-center">
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
                                                    ) !!} </p>
                                            @else
                                                <h3 class="mb-4">
                                                    {{ translate('Your download is ready', 'download pages') }} </h3>
                                                @endif <a href="#"
                                                    class="btn {{ $method == 'free' ? 'btn-secondary' : 'btn-primary' }} btn-md fw-500 disabled">
                                                    <i class="fa-solid fa-download me-1"></i>
                                                    {{ translate('Click Here to Download', 'download pages') }} </a>
                                        </div>
                                    </div>
                                </div> <x-ad alias="download_page_3_center_bottom" @class('ad-970x250 mt-4') />
                                @if ($themeSettings->download_pages->file_about)
                                    @include('themes.basic.files.common.about', [
                                        'fileEntry' => $fileEntry,
                                    ])
                                    @endif
                            </div>
                        </div> <x-ad alias="download_page_3_bottom" @class('ad-970x250 mt-5') />
                        @if ($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page3_extra_text)
                            <div class="file-card mt-5"> {!! $themeSettings->download_pages->page3_extra_text !!} </div>
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
