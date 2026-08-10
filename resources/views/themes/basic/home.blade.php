@extends('themes.basic.layouts.front')
@section('title', $seoConfiguration->title ?? '')
@section('content')
    @if ($themeSettings->home_page->header_section)
        <header class="header">
            <div class="wrapper">
                <div class="header-bg"
                    style="background-image: url({{ asset($themeSettings->home_page->header_background) }});">
                </div>
                <div class="container">
                    <div class="wrapper-content">
                        <div class="wrapper-container">
                            <div class="row row-cols-2 align-items-center g-4">
                                <div class="col-12 col-lg-5 order-2 order-lg-1">
                                    <h1 class="header-title" data-aos="fade-right" data-aos-duration="1000">
                                        {{ translate('Upload Files & Earn Money', 'home page') }}
                                    </h1>
                                    <p class="header-text lead text-muted" data-aos="fade-right" data-aos-duration="1000">
                                        {{ translate('hero_description', 'home page') }}
                                    </p>
                                    <div data-aos="fade-up" data-aos-duration="1000">
                                        @if (subscription()->plan->upload_status)
                                            <button class="btn btn-primary btn-lg" data-upload-btn><i
                                                    class="fa-solid fa-arrow-up-from-bracket me-2"></i>{{ translate('Upload Files', 'home page') }}</button>
                                        @else
                                            <a href="{{ auth()->user() ? route('user.settings.subscription') : route('login') }}"
                                                class="btn btn-primary btn-lg"><i
                                                    class="fa-solid fa-arrow-up-from-bracket me-2"></i>{{ translate('Upload Files', 'home page') }}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-lg-7 order-1 order-lg-2">
                                    <div class="header-img" data-aos="zoom-in" data-aos-duration="1000">
                                        <img src="{{ asset($themeSettings->home_page->header_image) }}"
                                            alt="{{ $settings->general->site_name }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    {{-- <x-ad alias="home_page_top" @class('ad-728x90 my-4') /> --}}
    @if ($themeSettings->home_page->features_section && $features->count() > 0)
        <div class="section section-start">
            <div class="container">
                <div class="section-inner">
                    <div class="row g-5 align-items-center">
                        <div class="col-12 col-lg-7 col-xxl-6 order-2 order-lg-1" data-aos="fade-right"
                            data-aos-duration="1000">
                            <div class="section-body">
                                <div class="row row-cols-1 row-cols-sm-2 g-4 align-items-center">
                                    @php
                                        $featuresCounter = 0;
                                    @endphp
                                    @foreach ($features->chunk(3) as $chunk)
                                        <div class="col">
                                            <div class="row row-cols-1 g-4">
                                                @foreach ($chunk as $feature)
                                                    <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                                        <div
                                                            class="feature {{ $featuresCounter % 2 == 1 ? ' feature-secondary' : '' }}">
                                                            <div class="feature-icon">
                                                                <img src="{{ asset($feature->image) }}"
                                                                    alt="{{ $feature->title }}" />
                                                            </div>
                                                            <h5 class="feature-title">{{ $feature->title }}</h5>
                                                            <p class="feature-text text-muted">{{ $feature->body }}</p>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $featuresCounter++;
                                                    @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 col-xxl-6 order-1 order-lg-2" data-aos="fade-left"
                            data-aos-duration="1000">
                            <div class="section-header mb-0">
                                <h2 class="section-title">{{ translate('Our Features', 'home page') }}</h2>
                                <p class="section-text text-muted lead">
                                    {{ translate('features description', 'home page') }}</p>
                                @guest
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('register') }}"
                                            class="btn btn-primary btn-md">{{ translate('Get Started', 'home page') }}</a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($themeSettings->home_page->steps_section && $steps->count() > 0)
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('How it Works', 'home page') }}</h2>
                        <p class="section-text text-muted lead">{{ translate('How it Works Description', 'home page') }}
                        </p>
                    </div>
                    <div class="section-body">
                        <div class="steps">
                            <div class="steps-border">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1587.904" height="309.319"
                                    viewBox="0 0 1587.904 309.319">
                                    <path id="Path_4115" data-name="Path 4115"
                                        d="M-5287.292-3794.361c49.612,33.755,149.847,128.154,198.448,135.021,25.759,3.64,32.252-19.748,19.811-35.13-10.691-13.22-33.506-12.486-39.092-7.4-11.886,10.83-49.988,78.383,19.282,101.428s150.428-36.252,310.889-8.188,150.087,128.105,330.955,120.445,392.513-151.086,392.513-151.086,169.3-39.945,176.487-84.645-78.219-15.853-49.2,7.919,226.344,114.767,226.344,114.767"
                                        transform="translate(5288.135 3795.601)" fill="none" class="stroke-color"
                                        stroke-width="3" stroke-dasharray="10" />
                                </svg>
                            </div>
                            <div class="row row-cols-1 row-cols-lg-3 g-4">
                                @php
                                    $stepCounter = 1;
                                @endphp
                                @foreach ($steps as $stepKey => $step)
                                    <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                        <div
                                            class="step {{ $stepCounter == 2 ? 'step-primary step-margin' : 'step-secondary' }}">
                                            <div class="step-number">{{ $stepCounter }}</div>
                                            <h4 class="step-title">{{ $step->title }}</h4>
                                            <p class="step-text">{{ $step->body }}</p>
                                        </div>
                                    </div>
                                    @php
                                        $stepCounter++;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- <x-ad alias="home_page_center" @class('ad-728x90 my-4') /> --}}
    @if ($themeSettings->home_page->faqs_section && $faqs->count() > 0)
        <div class="section section-bg section-margin"
            style="background-image: url({{ asset($themeSettings->home_page->section_background_image) }});">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('FAQs', 'home page') }}</h2>
                        <p class="section-text text-muted lead">{{ translate('FAQs Description', 'home page') }}</p>
                    </div>
                    <div class="section-body">
                        <div class="faq" data-aos="fade-up" data-aos-duration="1000">
                            <div class="accordion-custom">
                                <div class="accordion" id="accordion">
                                    @foreach ($faqs as $faq)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                                <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                                                    aria-controls="flush-collapseOne">
                                                    {{ $faq->title }}
                                                    <div class="accordion-button-icon">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $faq->id }}"
                                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    {!! $faq->body !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($themeSettings->home_page->blog_section && $settings->actions->blog_status && $blogArticles->count() > 0)
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('Latest Blog Posts', 'home page') }}</h2>
                        <p class="section-text text-muted lead">
                            {{ translate('Latest Blog Posts Description', 'home page') }}
                        </p>
                    </div>
                    <div class="section-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($blogArticles as $post)
                                <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                    @include('themes.basic.partials.blog-post', [
                                        'post' => $post,
                                    ])
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4" data-aos="fade-up" data-aos-duration="1000">
                            <a href="{{ route('blog.index') }}" class="btn btn-secondary btn-icon btn-md">
                                {{ translate('View All Blog Posts', 'home page') }}
                                <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- <x-ad alias="home_page_bottom" @class('ad-728x90 my-4') /> --}}
    @if ($themeSettings->home_page->withdrawal_methods_section)
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('Withdrawal Methods', 'home page') }}</h2>
                    </div>
                    <div class="section-body">
                        <div class="swiper-container" data-aos="fade-up" data-aos-duration="1000">
                            <div class="swiper swiper-brands">
                                <div class="swiper-wrapper align-items-center">
                                    @foreach ($withdrawalMethods as $withdrawalMethod)
                                        <div class="swiper-slide">
                                            <div class="brand">
                                                <img src="{{ asset($withdrawalMethod->logo) }}"
                                                    alt="{{ $withdrawalMethod->name }}" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-actions">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('themes.basic.includes.uploadbox')
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/aos/aos.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/aos/aos.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
    @endpush
@endsection
