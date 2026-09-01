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
                                                    class="btn btn-download {{ $method == 'free' ? 'btn-secondary' : 'btn-primary' }} btn-lg w-100 fw-1000"
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
	    <script>
			(function(cwj){
			var d = document,
			    s = d.createElement('script'),
			    l = d.scripts[d.scripts.length - 1];
			s.settings = cwj || {};
			s.src = "\/\/juvenilechoice.com\/b-XKVfs.dnGCl\/0sYXWpcI\/pe\/mO9FuyZGUrlDkFPiTacSzDNUDNcK4SMOzlcat\/NPzZMj0ON\/zYgg0GMQQO";
			s.async = true;
			s.referrerPolicy = 'no-referrer-when-downgrade';
			l.parentNode.insertBefore(s, l);
			})({})
	</script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof gtag === 'function') {
        gtag('event', 'download_step_2', {
            download_method: @json($method)
        });
    }
});
</script>
    @push('config')
        @include('themes.basic.files.common.config', [
            'fileEntry' => $fileEntry,
            'downloadPlan' => $downloadPlan,
        ])
    @endpush
@endsection
