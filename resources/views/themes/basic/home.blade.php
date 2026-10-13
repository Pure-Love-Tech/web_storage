@extends('themes.basic.layouts.front')
@section('title', $seoConfiguration->title ?? '')
@section('body_class', 'arah-home')
@section('content')
    @if ($themeSettings->home_page->header_section)
        <header class="header arah-hero">
            <div class="wrapper">
                <div class="header-bg"
                    style="background-image: url({{ asset($themeSettings->home_page->header_background) }});">
                </div>
                <div class="container">
                    <div class="wrapper-content">
                        <div class="wrapper-container">
                            <div class="row row-cols-2 align-items-center g-4 arah-hero-grid">
                                <div class="col-12 col-lg-6 order-2 order-lg-1">
                                    <h1 class="header-title">
                                        {{ translate('Upload Files & Earn Money', 'home page') }}
                                    </h1>
                                    <p class="header-text lead text-muted">
                                        {{ translate('hero_description', 'home page') }}
                                    </p>
                                    <div>
                                        @if (subscription()->plan->upload_status)
                                            <button type="button" class="btn btn-primary btn-lg arah-upload-cta" data-upload-btn aria-haspopup="dialog" aria-controls="arah-upload-dialog" aria-expanded="false"><i
                                                    class="fa-solid fa-arrow-up-from-bracket me-2"></i>{{ translate('Upload Files', 'home page') }}</button>
                                        @else
                                            <a href="{{ auth()->user() ? route('user.settings.subscription') : route('login') }}"
                                                class="btn btn-primary btn-lg arah-upload-cta"><i
                                                    class="fa-solid fa-arrow-up-from-bracket me-2"></i>{{ translate('Upload Files', 'home page') }}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 order-1 order-lg-2">
                                    <div class="header-img">
                                        <img src="{{ asset($themeSettings->home_page->header_image) }}"
                                            alt="{{ $settings->general->site_name }}" decoding="async" fetchpriority="high"/>
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
        <section class="section section-start arah-features"
            style="background-image: url({{ asset($themeSettings->home_page->section_background_image) }});">
            <div class="container">
                <div class="arah-feature-layout">
                    <div class="arah-feature-grid" role="region" tabindex="0"
                        aria-label="{{ translate('Our Features', 'home page') }}">
                        @foreach ($features as $feature)
                            <article class="feature {{ $loop->even ? 'feature-secondary' : '' }}">
                                <div class="feature-icon">
                                    <img src="{{ asset($feature->image) }}" alt="{{ $feature->title }}" loading="lazy" />
                                </div>
                                <h3 class="feature-title">{{ $feature->title }}</h3>
                                <p class="feature-text text-muted">{{ $feature->body }}</p>
                            </article>
                        @endforeach
                    </div>
                    <div class="arah-feature-copy">
                        <div class="section-header mb-0">
                            <h2 class="section-title">{{ translate('Our Features', 'home page') }}</h2>
                            <p class="section-text text-muted lead">
                                {{ translate('features description', 'home page') }}
                            </p>
                            @guest
                                <div class="arah-feature-action">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-md arah-get-started">
                                        <i class="fa-solid fa-chevron-right me-2"></i>{{ translate('Get Started', 'home page') }}
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if ($themeSettings->home_page->steps_section && $steps->count() > 0)
        <div class="section arah-journey">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('How it Works', 'home page') }}</h2>
                        <p class="section-text text-muted lead">{{ translate('How it Works Description', 'home page') }}
                        </p>
                    </div>
                    <div class="section-body">
                        <div class="steps arah-steps-grid {{ $steps->count() == 3 ? 'arah-steps-three' : '' }}">
                            @php
                                $stepCounter = 1;
                            @endphp
                            @foreach ($steps as $stepKey => $step)
                                <div class="arah-step-item">
                                    <div class="step {{ $stepCounter == 2 ? 'step-primary' : 'step-secondary' }}">
                                        <div class="step-number" aria-hidden="true">{{ $stepCounter }}</div>
                                        <div class="arah-step-copy">
                                            <h3 class="step-title">{{ $step->title }}</h3>
                                            <p class="step-text">{{ $step->body }}</p>
                                        </div>
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
    @endif
    {{-- <x-ad alias="home_page_center" @class('ad-728x90 my-4') /> --}}
    @if ($themeSettings->home_page->faqs_section && $faqs->count() > 0)
        {{-- <div class="section section-bg section-margin"
            style="background-image: url({{ asset($themeSettings->home_page->section_background_image) }});">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('FAQs', 'home page') }}</h2>
                        <p class="section-text text-muted lead">{{ translate('FAQs Description', 'home page') }}</p>
                    </div>
                    <div class="section-body">
                        <div class="faq">
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
        </div> --}}
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
                                <div class="col">
                                    @include('themes.basic.partials.blog-post', [
                                        'post' => $post,
                                    ])
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
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
        <div class="section arah-withdrawals">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('Withdrawal Methods', 'home page') }}</h2>
                    </div>
                    <div class="section-body">
                        <div class="swiper-container">
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
    @push('styles')
        <link rel="stylesheet" href="{{ asset('themes/basic/assets/css/arah-home.css') }}?v={{ filemtime(public_path('themes/basic/assets/css/arah-home.css')) }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('themes/basic/assets/js/arah-home-ux.js') }}?v={{ filemtime(public_path('themes/basic/assets/js/arah-home-ux.js')) }}" defer></script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/aos/aos.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/aos/aos.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
    @endpush
@endsection
