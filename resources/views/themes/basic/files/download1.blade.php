@extends('themes.basic.layouts.single')
@section('section', translate('Download', 'download pages'))
@section('title', $fileEntry->name)
@section('hide_header', true)
@section('content')
<style type="text/css">
	.btn-download {
    position: relative;
    overflow: hidden;
    border: 0;
    padding: 15px 24px;
    font-size: 1.05rem;
    font-weight: 800;
    letter-spacing: 0.2px;
    color: #fff;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    box-shadow: 0 8px 22px rgba(34, 197, 94, 0.35);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-download:hover {
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(34, 197, 94, 0.45);
}

.btn-download:active {
    transform: translateY(0);
}

/* Efek kilau */
.btn-download::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 70%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.25),
        transparent
    );
    transform: skewX(-20deg);
    animation: buttonShine 3s infinite;
}

@keyframes buttonShine {
    0% {
        left: -120%;
    }

    45%,
    100% {
        left: 150%;
    }
}
</style>
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
                                <div class="col-lg-12 m-auto download-section-box">
                                    @if (licenseType(2))
                                        <h5 class="text-center mb-5">
                                            {{ translate('Choose Download Type', 'download pages') }}
                                        </h5>
                                    @endif
                                    <div class="row row-cols-1 row-cols-lg-12 justify-content-center g-4">
                                        <div class="col-12">
                                            <div class="download-type">
                                                <form action="{{ route('files.file', $fileEntry->sharedId()) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="p" value="down_1">
                                                    <input type="hidden" name="method" value="free">
                                                    <button class="btn btn-download btn-lg radius w-100 fw-1000">
													    @if (licenseType(2))
													        {{ translate('Free Download', 'download pages') }}
													    @else
													        {{ translate('Continue To Download', 'download pages') }}
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
    @push('head_codes')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        if (typeof gtag === 'function') {
            gtag('event', 'download_step_1', {
                download_method: 'free'
            });
        }
    });
    </script>
    <script>(function(s){s.dataset.zone='11642163',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
    <script src="https://5gvci.com/act/files/tag.min.js?z=11642173" data-cfasync="false" async></script>
    <script>(function(s){s.dataset.zone='11642175',s.src='https://nap5k.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
<!-- <script src="https://quge5.com/88/tag.min.js" data-zone="272740" async data-cfasync="false"></script> -->
@endpush
    @push('config')
        @include('themes.basic.files.common.config', [
            'fileEntry' => $fileEntry,
            'downloadPlan' => subscription()->plan,
        ])
    @endpush

@endsection
