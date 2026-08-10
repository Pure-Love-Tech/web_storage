@extends('themes.basic.layouts.auth')
@section('title', translate('Sign In', 'auth'))
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 align-items-center g-5">
        <div class="col">
            <div class="section-header">
                <h2 class="section-title text-capitalize mb-0">{{ translate('Sign In', 'auth') }}</h2>
            </div>
            <div class="section-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label form-label-lg">{{ translate('Username', 'forms') }} : <span
                                class="required">*</span></label>
                        <div class="form-icon radius">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="19.561" height="22.936" viewBox="0 0 19.561 22.936">
                                    <defs>
                                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1"
                                            gradientUnits="objectBoundingBox">
                                            <stop offset="0" stop-color="var(--primary_color)" />
                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                        </linearGradient>
                                    </defs>
                                    <g id="_2354573" data-name="2354573" transform="translate(0 0)">
                                        <path id="Path_802" data-name="Path 802"
                                            d="M-525.44,208.44a18.7,18.7,0,0,1-6.5-1.111,6.3,6.3,0,0,1-2.44-1.533,2.637,2.637,0,0,1-.746-1.925,9.565,9.565,0,0,1,2.822-6.661.892.892,0,0,1,1.288-.067.871.871,0,0,1-.02,1.3,7.823,7.823,0,0,0-2.222,4.405c-.048.317-.053.64-.089.959a1.077,1.077,0,0,0,.407.948,5.329,5.329,0,0,0,1.879,1.036,17.7,17.7,0,0,0,6.729.856,14.923,14.923,0,0,0,4.7-.864,10.2,10.2,0,0,0,1.622-.825,1.346,1.346,0,0,0,.663-1.378,7.967,7.967,0,0,0-2.282-5.1.981.981,0,0,1-.357-.827.845.845,0,0,1,.585-.736.855.855,0,0,1,.942.225,9.554,9.554,0,0,1,2.5,4.165,10.1,10.1,0,0,1,.39,2.551,2.716,2.716,0,0,1-.952,2.145,7.464,7.464,0,0,1-2.848,1.548A19.809,19.809,0,0,1-525.44,208.44Z"
                                            transform="translate(535.124 -185.504)" fill="url(#linear-gradient)"
                                            opacity=".8" />
                                        <path id="Path_803" data-name="Path 803"
                                            d="M-487.19,48.792A6.2,6.2,0,0,1-481,42.62a6.2,6.2,0,0,1,6.256,6.242,6.209,6.209,0,0,1-6.2,6.105A6.209,6.209,0,0,1-487.19,48.792Zm1.778-.018A4.431,4.431,0,0,0-481,53.2a4.429,4.429,0,0,0,4.478-4.416,4.432,4.432,0,0,0-4.465-4.4A4.437,4.437,0,0,0-485.413,48.774Z"
                                            transform="translate(490.747 -42.62)" fill="url(#linear-gradient)" />
                                    </g>
                                </svg>
                            </div>
                            <input type="username" name="username" class="form-control form-control-md"
                                value="{{ old('username') }}" placeholder="{{ translate('Username', 'forms') }}"
                                minlength="6" maxlength="50" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-lg">{{ translate('Password', 'forms') }} : <span
                                class="required">*</span></label>
                        <div class="form-icon radius">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="15.416" height="21" viewBox="0 0 15.416 21">
                                    <defs>
                                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1"
                                            gradientUnits="objectBoundingBox">
                                            <stop offset="0" stop-color="var(--primary_color)" />
                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                        </linearGradient>
                                    </defs>
                                    <g id="_2787245" data-name="2787245" transform="translate(349.011 -6.826)">
                                        <path id="Path_8121" data-name="Path 8121"
                                            d="M-347.17,196.753a5.325,5.325,0,0,1-.933-.393,1.967,1.967,0,0,1-.9-1.725c-.007-2.324-.014-4.649,0-6.974a2.079,2.079,0,0,1,2.15-2.11q5.548-.006,11.1,0a2.073,2.073,0,0,1,2.149,2.11q.025,3.486,0,6.973a2.072,2.072,0,0,1-1.758,2.086.361.361,0,0,0-.074.032Zm5.878-9.806v0h-5.475a.731.731,0,0,0-.84.839q0,3.363,0,6.726a.732.732,0,0,0,.84.84h10.93a.733.733,0,0,0,.838-.843q0-3.363,0-6.726c0-.578-.262-.841-.837-.841Z"
                                            transform="translate(0 -168.927)" fill="url(#linear-gradient)" opcity=".8" />
                                        <path id="Path_8122" data-name="Path 8122"
                                            d="M-298.05,12.946c.022-.635,0-1.274.076-1.9A4.864,4.864,0,0,1-294.02,6.9a4.884,4.884,0,0,1,5.7,3.936,4.888,4.888,0,0,1,.079.876c.01.916.009,1.832,0,2.748a.7.7,0,0,1-.93.723.721.721,0,0,1-.477-.737c0-.916.007-1.832,0-2.748a3.48,3.48,0,0,0-2.282-3.266,3.5,3.5,0,0,0-4.7,3.15c-.022.991,0,1.982-.006,2.973a.7.7,0,0,1-.477.694.662.662,0,0,1-.768-.232.961.961,0,0,1-.148-.474c-.018-.533-.007-1.066-.007-1.6Z"
                                            transform="translate(-48.168 0)" fill="url(#linear-gradient)" />
                                        <path id="Path_8123" data-name="Path 8123"
                                            d="M-221.177,264.673c0-.232,0-.465,0-.7a.687.687,0,0,1,.681-.678.687.687,0,0,1,.712.668q.013.7,0,1.394a.7.7,0,0,1-.693.695.7.7,0,0,1-.7-.706C-221.18,265.124-221.176,264.9-221.177,264.673Z"
                                            transform="translate(-120.826 -242.416)" fill="url(#linear-gradient)" />
                                    </g>
                                </svg>
                            </div>
                            <input type="password" name="password" class="form-control form-control-md"
                                placeholder="{{ translate('Password', 'forms') }}" required />
                        </div>
                    </div>
                    <div class="row row-cols-auto justify-content-between g-3 mb-3">
                        <div class="col">
                            <div class="form-check  form-check-lg">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label form-label-md mb-0" for="formCheckDefault">
                                    {{ translate('Remember Me', 'auth') }}
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <a href="{{ route('password.request') }}" class="link link-secondary underline fw-500">
                                {{ translate('Forgot Your Password?', 'auth') }}
                            </a>
                        </div>
                    </div>
                    <x-captcha />
                    <button class="btn btn-primary btn-md w-100 fw-500">{{ translate('Sign In', 'auth') }}</button>
                </form>
                <x-oauth-buttons />
                @if ($settings->actions->registration_status)
                    <div class="mt-4">
                        <div class="form-label form-label-lg">
                            {{ translate('You do not have an account?', 'auth') }}
                            <a href="{{ route('register') }}" class="link link-secondary">
                                {{ translate('Create an Account', 'auth') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col">
            <div class="sign-img">
                <img src="{{ asset($themeSettings->authentication->signin_page_image) }}"
                    alt="{{ translate('Sign In', 'auth') }}" />
            </div>
        </div>
    </div>
@endsection
