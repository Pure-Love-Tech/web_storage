<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    @include('themes.basic.includes.head')
    @include('themes.basic.includes.styles')
    <x-ad alias="head_code" />
    {!! $themeSettings->extra_codes->head_code !!}
</head>

@include('themes.basic.partials.adblock-full')
@stack('head_codes')

<body>
    @include('themes.basic.partials.preloader')
    @if (!$themeSettings->pages->header_section)
        @section('hide_header', true)
    @endif
    @include('themes.basic.includes.navbar')
    @if (!$__env->yieldContent('hide_header'))
        <header class="header" style="height: 300px">
            <div class="wrapper wrapper-page wrapper-page-bg" style="min-height: 150px;">
                <div class="header-wave">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 63.156" preserveAspectRatio="none" style="height: 220px">
                        <path class="cls-1"
                            d="M-200,96c6.9-39.685,171.983-54,187.781-17.444C-10.065,83.541-12.3,92.293-7,98c6.757,7.274,21.691,6.844,45-1,20.911-7.037,46.959-23.587,54-27,10.769-5.22,40.573-11.949,71-13,34.518-1.192,61.424,4.962,96,15,32.508,9.438,59.481,20.658,91,26,33.112,5.612,70.867,6.129,114-1,38.4-6.346,73.154-23.231,119-26,28.359-1.713,52.693-.12,73,4,26.442,5.364,55.2,20.678,91,23a203.83,203.83,0,0,0,74-9c21.836-6.947,34.934-16.821,57-23,32.83-9.193,59.894-8.183,77-4,14.388,3.518,27.721,11.54,44,19,23.55,10.793,40.55,16.779,59,17,11.3,0.135,27.94-2.424,46-9,15.98-5.818,24.84-13.71,41-19,15.12-4.949,37.63-6.733,66-2,71.8,11.978,109.26,30.28,115,52,11.78,44.57-79.3,107.069-143,144C983.131,379.876,686.023,418.111,218,281,59.276,234.5-209.106,148.388-200,96Z"
                            transform="translate(0 -56.844)" />
                    </svg>
                </div>
                <div class="container">
                    <div class="wrapper-content">
                        <div class="wrapper-container">
                            <h1 class="page-title">@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    @yield('content')
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.scripts')
    {!! $themeSettings->extra_codes->footer_code !!}
</body>

</html>
