<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    @include('backend.includes.head')
    <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/backend/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backend/css/application.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css') }}">
</head>

<body>
    <div class="vironeer-sign-container">
        <div class="vironeer-sign-form">
            <div class="card">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/backend/js/application.js') }}"></script>
    @toastrRender
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @elseif(session('status'))
        <script>
            toastr.success('{{ session('status') }}')
        </script>
    @endif
</body>

</html>
