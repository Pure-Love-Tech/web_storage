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
                        <x-ad alias="download_page_1_top" @class('ad-970x250 mb-4') />
                        <div class="file-card">
                            <div class="file-details">
                                @include('themes.basic.files.common.details')
                                <x-ad alias="download_page_1_center_top" @class('ad-970x250 mb-4') />
                                <div class="col-lg-7 m-auto download-section-box">
                                    @if (licenseType(2))
                                        <h5 class="text-center mb-5">
                                            {{ translate('Choose Download Type', 'download pages') }}
                                        </h5>
                                    @endif
                                    <div class="row row-cols-1 row-cols-lg-2 justify-content-center g-4">
                                        <div class="col">
                                            <div class="download-type">
                                                <form action="{{ route('files.file', $fileEntry->sharedId()) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="p" value="down_1">
                                                    <input type="hidden" name="method" value="free">
                                                    <button class="btn btn-secondary btn-md radius w-100 fw-500">
                                                        @if (licenseType(2))
                                                            {{ translate('Free Download', 'download pages') }}
                                                        @else
                                                            {{ translate('Continue', 'download pages') }}
                                                            <i class="fa-solid fa-arrow-right ms-2"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @if (licenseType(2))
                                            <div class="col">
                                                <div class="download-type">
                                                    <form action="{{ route('files.file', $fileEntry->sharedId()) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="p" value="down_1">
                                                        <input type="hidden" name="method" value="premium">
                                                        <button class="btn btn-primary btn-md radius w-100 fw-500">
                                                            <i class="fa fa-star me-1"></i>
                                                            {{ translate('Premium Download', 'download pages') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <x-ad alias="download_page_1_center_bottom" @class('ad-970x250 mt-4') />
                            </div>
                            @if ($themeSettings->download_pages->file_about)
                                @include('themes.basic.files.common.about', [
                                    'fileEntry' => $fileEntry,
                                ])
                            @endif
                        </div>
                        <x-ad alias="download_page_1_bottom" @class('ad-970x250 mt-5') />
                        @if ($themeSettings->download_pages->extra_text_sections && $themeSettings->download_pages->page1_extra_text)
                            <div class="file-card mt-5">
                                {!! $themeSettings->download_pages->page1_extra_text !!}
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
            'downloadPlan' => subscription()->plan,
        ])
    @endpush
@endsection
