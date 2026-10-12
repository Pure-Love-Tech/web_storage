<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    @include('themes.basic.includes.head')
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
    @endpush
    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
    @include('themes.basic.includes.styles')
    <x-ad alias="head_code" />
    {!! $themeSettings->extra_codes->head_code !!}
</head>

@include('themes.basic.partials.adblock-full')
@stack('head_codes')

<body class="dash-body">
    @include('themes.basic.partials.preloader')
    <div class="dash">
        @include('themes.basic.user.includes.sidebar')
        <div class="dash-inner">
            @include('themes.basic.user.includes.navbar')
            <div class="dash-container">
                <div class="page-body">
                    <div class="row row-cols-auto g-2 justify-content-between align-items-center mb-4">
                        <div class="col">
                            <h3 class="mb-0">@yield('title')</h3>
                        </div>
                        <div class="col">
                            @if (request()->routeIs('user.dashboard'))
                                <div class="dash-select">
                                    <div class="dash-select-icon">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                    <select id="period-select" class="form-select radius w-auto">
                                        @foreach ($dates as $date)
                                            <option value="{{ route('user.dashboard', 'period=' . $date['key']) }}"
                                                @selected(request('period') == $date['key'])>
                                                {{ $date['value'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @hasSection('back')
                                <a href="@yield('back')" class="btn btn-outline-secondary radius radius-md"><i
                                        class="fa-solid fa-arrow-left me-2"></i>{{ translate('Back') }}</a>
                            @endif
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
            @include('themes.basic.includes.uploadbox')
            @include('themes.basic.user.includes.footer')
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
    @endpush
    @include('themes.basic.includes.scripts')
    {!! $themeSettings->extra_codes->footer_code !!}
</body>

</html>
