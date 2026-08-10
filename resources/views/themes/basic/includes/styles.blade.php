<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css') }}">
@stack('styles_libs')
@themeColors
<link rel="stylesheet" href="{{ theme_asset('assets/css/app.css') }}">
@stack('styles')
@themeCustomStyle
