<x-partials />
<script>
    "use strict";
    const config = {!! json_encode([
        'lang' => getLocale(),
        'url' => url('/'),
        'colors' => $themeSettings->colors,
        'translates' => [
            'copied' => translate('Copied to clipboard'),
            'actionConfirm' => translate('Are you sure?'),
        ],
    ]) !!};
</script>
@stack('config')
@stack('top_scripts')
<script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
@stack('scripts_libs')
<!-- <script src="{{ theme_asset('assets/js/app.js') }}"></script> -->
<script src="{{ theme_asset('assets/js/app.js') }}?v={{ filemtime(public_path('themes/basic/assets/js/app.js')) }}"></script>
@toastrRender
@stack('scripts')
