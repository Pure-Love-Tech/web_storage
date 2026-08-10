<script type="text/javascript">
    "use strict";
    const config = {!! json_encode([
        'url' => adminUrl(),
        'colors' => $settings->system->colors,
    ]) !!}
</script>
@stack('top_scripts')
<script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('vendor/libs/sweetalert/sweetalert2.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
<script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
<script src="{{ asset('vendor/backend/js/application.js') }}"></script>
@toastrRender
@stack('scripts')
