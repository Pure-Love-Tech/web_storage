@extends('themes.basic.user.layouts.app')
@section('title', translate('Settings', 'settings'))
@section('content')
    @include('themes.basic.user.settings.includes.links')
    <div class="card-v">
        <h5 class="mb-0">{{ translate('2FA Authentication', 'settings') }}</h5>
        <div class="form-section">
            <p class="text-muted">
                {{ translate('2fa top description', 'settings') }}
            </p>
            <div class="my-3">
                <div class="row g-3 align-items-center">
                    @if (!$user->google2fa_status)
                        <div class="col-12 col-md-12 col-lg-auto col-xl-auto">
                            <div class="text-center mb-2">
                                {!! $QR_Image !!}
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6 col-xl-3">
                            <div class="input-group mb-3">
                                <input id="input-link" type="text" class="form-control form-control-md radius radius-md"
                                    value="{{ $user->google2fa_secret }}" readonly>
                                <button class="btn btn-outline-secondary radius radius-md btn-copy"
                                    data-clipboard-target="#input-link"><i class="far fa-clone"></i></button>
                            </div>
                            <a href="#" class="btn btn-primary btn-md w-100 radius radius-md" data-bs-toggle="modal"
                                data-bs-target="#towfactorModal">{{ translate('Enable 2FA Authentication', 'settings') }}</a>
                        </div>
                    @else
                        <div class="col-lg-3">
                            <a href="#" class="btn btn-danger btn-md w-100 radius radius-md" data-bs-toggle="modal"
                                data-bs-target="#towfactorDisableModal">{{ translate('Disable 2FA Authentication', 'settings') }}</a>
                        </div>
                    @endif
                </div>
            </div>
            <p class="text-muted mb-2">
                {{ translate('2fa bottom description', 'settings') }}:
            </p>
            <li class="mb-1"><a target="_blank"
                    href="https://apps.apple.com/us/app/google-authenticator/id388497605">{{ translate('Google Authenticator for iOS', 'settings') }}</a>
            </li>
            <li class="mb-1"><a target="_blank"
                    href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&gl=US">{{ translate('Google Authenticator for Android', 'settings') }}</a>
            </li>
            <li class="mb-1"><a target="_blank"
                    href="https://apps.apple.com/us/app/microsoft-authenticator/id983156458">{{ translate('Microsoft Authenticator for iOS', 'settings') }}</a>
            </li>
            <li class="mb-0"><a target="_blank"
                    href="https://play.google.com/store/apps/details?id=com.azure.authenticator&hl=en_US&gl=US">{{ translate('Microsoft Authenticator for Android', 'settings') }}</a>
            </li>
        </div>
    </div>
    @if (!$user->google2fa_status)
        <div class="modal fade" id="towfactorModal" aria-labelledby="towfactorModalLabel" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ translate('OTP Code', 'forms') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.settings.2fa.enable') }}" method="POST">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="mb-4">
                                <input type="text" name="otp_code"
                                    class="form-control form-control-md radius radius-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-secondary btn-md radius radius-md w-100"
                                        data-bs-dismiss="modal">{{ translate('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit"
                                        class="btn btn-primary btn-md w-100 radius radius-md">{{ translate('Enable', 'settings') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="towfactorDisableModal" tabindex="-1" aria-labelledby="towfactorDisableModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ translate('OTP Code', 'forms') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.settings.2fa.disable') }}" method="POST">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="mb-4">
                                <input type="text" name="otp_code"
                                    class="form-control form-control-md radius radius-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-secondary btn-md radius radius-md w-100"
                                        data-bs-dismiss="modal">{{ translate('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit"
                                        class="btn btn-danger btn-md radius radius-md w-100">{{ translate('Disable', 'settings') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
