@extends('themes.basic.layouts.auth')
@section('title', translate('Sign Up', 'auth'))
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 align-items-center g-5">
        <div class="col">
            <div class="section-header">
                <h2 class="section-title text-capitalize mb-0">{{ translate('Sign Up', 'auth') }}</h2>
            </div>
            <div class="section-body">
                <form action="{{ route('register') }}" method="POST">
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
                            <input type="text" name="username" class="form-control form-control-md"
                                value="{{ old('username') }}" placeholder="{{ translate('Username', 'forms') }}"
                                minlength="5" maxlength="50" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-lg">{{ translate('Email address', 'forms') }} : <span
                                class="required">*</span></label>
                        <div class="form-icon radius">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="25.105" height="16.749" viewBox="0 0 25.105 16.749">
                                    <defs>
                                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1"
                                            gradientUnits="objectBoundingBox">
                                            <stop offset="0" stop-color="var(--primary_color)" />
                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                        </linearGradient>
                                    </defs>
                                    <path id="Path_804" data-name="Path 804"
                                        d="M-438.18,48.6a4.273,4.273,0,0,1,.415-.7,1.276,1.276,0,0,1,1.029-.363q4.645,0,9.29,0,6.471,0,12.943,0A1.309,1.309,0,0,1-413.1,48.6a1.854,1.854,0,0,1,.022.341q0,6.963,0,13.926a1.3,1.3,0,0,1-1.4,1.411q-11.153,0-22.306,0c-.717,0-1.076-.279-1.4-1.066Q-438.18,55.9-438.18,48.6Zm24.113,13.985V49.133c-.1.071-.172.121-.242.175q-4.94,3.706-9.881,7.412a2.283,2.283,0,0,1-2.876,0l-9.9-7.425c-.068-.051-.138-.1-.224-.16V62.581c.1-.116.166-.194.23-.274q2.229-2.753,4.457-5.507c.242-.3.477-.6.73-.891a.469.469,0,0,1,.662-.05.481.481,0,0,1,.087.641,1.38,1.38,0,0,1-.1.136l-5.2,6.421c-.058.072-.114.147-.183.235h21.762c-.06-.081-.1-.141-.147-.2q-1.6-1.973-3.193-3.943-1.041-1.286-2.081-2.573a.488.488,0,0,1,.151-.8c.226-.094.429-.021.634.232l3.778,4.668Zm-22.318-14.077c.105.085.166.136.229.183l9.68,7.264a1.322,1.322,0,0,0,1.694,0q4.86-3.645,9.718-7.292c.053-.04.1-.087.179-.156Z"
                                        transform="translate(438.18 -47.53)" fill="url(#linear-gradient)" />
                                </svg>
                            </div>
                            <input type="email" name="email" class="form-control form-control-md"
                                placeholder="{{ translate('Email address', 'forms') }}" value="{{ old('email') }}"
                                required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-lg">{{ translate('Password', 'forms') }} : <span
                                class="required">*</span>
                        </label>
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
                                            transform="translate(0 -168.927)" fill="url(#linear-gradient)"
                                            opcity=".8" />
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
                                placeholder="{{ translate('Password', 'forms') }}" minlength="8" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-lg">{{ translate('Confirm password', 'forms') }} : <span
                                class="required">*</span>
                        </label>
                        <div class="form-icon radius">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="15.416" height="21" viewBox="0 0 15.416 21">
                                    <defs>
                                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5"
                                            y2="1" gradientUnits="objectBoundingBox">
                                            <stop offset="0" stop-color="var(--primary_color)" />
                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                        </linearGradient>
                                    </defs>
                                    <g id="_2787245" data-name="2787245" transform="translate(349.011 -6.826)">
                                        <path id="Path_8121" data-name="Path 8121"
                                            d="M-347.17,196.753a5.325,5.325,0,0,1-.933-.393,1.967,1.967,0,0,1-.9-1.725c-.007-2.324-.014-4.649,0-6.974a2.079,2.079,0,0,1,2.15-2.11q5.548-.006,11.1,0a2.073,2.073,0,0,1,2.149,2.11q.025,3.486,0,6.973a2.072,2.072,0,0,1-1.758,2.086.361.361,0,0,0-.074.032Zm5.878-9.806v0h-5.475a.731.731,0,0,0-.84.839q0,3.363,0,6.726a.732.732,0,0,0,.84.84h10.93a.733.733,0,0,0,.838-.843q0-3.363,0-6.726c0-.578-.262-.841-.837-.841Z"
                                            transform="translate(0 -168.927)" fill="url(#linear-gradient)"
                                            opcity=".8" />
                                        <path id="Path_8122" data-name="Path 8122"
                                            d="M-298.05,12.946c.022-.635,0-1.274.076-1.9A4.864,4.864,0,0,1-294.02,6.9a4.884,4.884,0,0,1,5.7,3.936,4.888,4.888,0,0,1,.079.876c.01.916.009,1.832,0,2.748a.7.7,0,0,1-.93.723.721.721,0,0,1-.477-.737c0-.916.007-1.832,0-2.748a3.48,3.48,0,0,0-2.282-3.266,3.5,3.5,0,0,0-4.7,3.15c-.022.991,0,1.982-.006,2.973a.7.7,0,0,1-.477.694.662.662,0,0,1-.768-.232.961.961,0,0,1-.148-.474c-.018-.533-.007-1.066-.007-1.6Z"
                                            transform="translate(-48.168 0)" fill="url(#linear-gradient)" />
                                        <path id="Path_8123" data-name="Path 8123"
                                            d="M-221.177,264.673c0-.232,0-.465,0-.7a.687.687,0,0,1,.681-.678.687.687,0,0,1,.712.668q.013.7,0,1.394a.7.7,0,0,1-.693.695.7.7,0,0,1-.7-.706C-221.18,265.124-221.176,264.9-221.177,264.673Z"
                                            transform="translate(-120.826 -242.416)" fill="url(#linear-gradient)" />
                                    </g>
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control form-control-md"
                                placeholder="{{ translate('Confirm password', 'forms') }}" minlength="8" required>
                        </div>
                    </div>
                    @if ($settings->general->terms_of_service_link)
                        <div class="form-check  form-check-lg my-4">
                            <input id="terms" name="terms" class="form-check-input" type="checkbox"
                                {{ old('terms') ? 'checked' : '' }} required>
                            <label class="form-check-label form-label-md mb-0" for="terms">
                                {{ translate('I agree to the', 'auth') }}
                                <a href="{{ $settings->general->terms_of_service_link }}"
                                    class="link link-secondary">{{ translate('terms of service', 'auth') }}</a>
                            </label>
                        </div>
                    @endif
                    <x-captcha />
                    <button class="btn btn-primary btn-md w-100 fw-500">{{ translate('Sign Up', 'auth') }}</button>
                </form>
                <x-oauth-buttons />
            </div>
        </div>
        <div class="col">
            <div class="sign-img">
                <img src="{{ asset($themeSettings->authentication->signup_page_image) }}"
                    alt="{{ translate('Sign Up', 'auth') }}" />
            </div>
        </div>
    </div>
@endsection
