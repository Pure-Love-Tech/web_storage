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
    @include('themes.basic.includes.navbar')
    @yield('content')
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.scripts')
    {!! $themeSettings->extra_codes->footer_code !!}
</body>

</html>
