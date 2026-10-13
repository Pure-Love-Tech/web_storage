<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css') }}">
@stack('styles_libs')
@themeColors
<link rel="stylesheet" href="{{ theme_asset('assets/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('themes/basic/assets/css/arah-public.css') }}?v={{ filemtime(public_path('themes/basic/assets/css/arah-public.css')) }}">
@stack('styles')
<link rel="stylesheet" href="{{ asset('themes/basic/assets/css/arah-public-extended.css') }}?v={{ filemtime(public_path('themes/basic/assets/css/arah-public-extended.css')) }}">
<link rel="stylesheet" href="{{ asset('themes/basic/assets/css/arah-navbar.css') }}?v={{ filemtime(public_path('themes/basic/assets/css/arah-navbar.css')) }}">
@themeCustomStyle
