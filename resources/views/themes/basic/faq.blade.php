@extends('themes.basic.layouts.single')
@section('title', 'FAQs')
{{-- @section('description', $faqs->short_description)  --}}
@section('content')
    <div class="section section-start">
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    {{-- <h2 class="section-title text-capitalize mb-0">{{ translate('faqsS', 'pages') }}</h2> --}}
                </div>
                <div class="section-body">
                    <div class="faqs" data-aos="fade-up" data-aos-duration="1000">
                        <div class="accordion-custom">
                            <div class="accordion" id="accordion">
                                @foreach ($faqs as $faqs)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $faqs->id }}">
                                            <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}"
                                                type="button" data-bs-toggle="collapse" style="border : 1px solid #4194e6"
                                                data-bs-target="#collapse{{ $faqs->id }}" aria-expanded="false"
                                                aria-controls="flush-collapseOne">
                                                {{ $faqs->title }}
                                                <div class="accordion-button-icon">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $faqs->id }}"
                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                            aria-labelledby="heading{{ $faqs->id }}" data-bs-parent="#accordion">
                                            <div class="accordion-body" style="background: #d9e9fa !important">
                                                {!! $faqs->body !!}
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
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/aos/aos.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/aos/aos.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
    @endpush
@endsection
