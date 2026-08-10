<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    @include('backend.includes.head')
    @include('backend.includes.styles')
</head>

<body>
    @include('backend.includes.sidebar')
    <div class="vironeer-page-content">
        @include('backend.includes.navbar')
        <div class="container @yield('container')">
            <div class="vironeer-page-body px-1 px-sm-2 px-xxl-0">
                <div class="py-4 g-4">
                    <div class="row align-items-center">
                        <div class="col">
                            @include('backend.includes.breadcrumb')
                        </div>
                        <div class="col-auto">
                            @hasSection('back')
                                <a href="@yield('back')" class="btn btn-secondary ms-2"><i
                                        class="fas fa-arrow-left me-2"></i>{{ admin_trans('Back') }}</a>
                            @endif
                            @hasSection('language')
                                <div class="dropdown d-inline ms-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-globe me-2"></i>{{ $active }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @foreach ($adminLanguages as $adminLanguage)
                                            <li><a class="dropdown-item @if ($adminLanguage->name == $active) active @endif"
                                                    href="?lang={{ $adminLanguage->code }}">{{ $adminLanguage->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @hasSection('modal')
                                <button type="button" class="btn btn-dark ms-2" data-bs-toggle="modal"
                                    data-bs-target="#viewModal">
                                    @yield('modal')
                                </button>
                            @endif
                            @hasSection('link')
                                <a href="@yield('link')" class="btn btn-primary ms-2"><i class="fa fa-plus"></i></a>
                            @endif
                            @hasSection('upload_modal')
                                <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#uploadModal">
                                    <i class="fa fa-upload me-2"></i>@yield('upload_modal')
                                </button>
                            @endif
                            @if (request()->routeIs('admin.notifications.index'))
                                <a class="vironeer-link-confirm btn btn-outline-success ms-2"
                                    href="{{ route('admin.notifications.readall') }}">{{ admin_trans('Make All as Read') }}</a>
                                <form class="d-inline ms-2" action="{{ route('admin.notifications.deleteallread') }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="vironeer-able-to-delete btn btn-outline-danger">
                                        {{ admin_trans('Delete All Read') }}</button>
                                </form>
                            @endif
                            @if (request()->routeIs('admin.system.info.index'))
                                <a href="{{ config('vironeer.author.profile') }}" target="_blank"
                                    class="btn btn-secondary"><i
                                        class="far fa-question-circle me-2"></i>{{ admin_trans('Get Help') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row g-3 g-xl-3">
                    <div class="col">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('backend.includes.footer')
    </div>
    @include('backend.includes.scripts')
</body>

</html>
