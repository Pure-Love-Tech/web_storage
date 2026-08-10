@extends('themes.basic.layouts.auth')
@section('title', translate('Reset Password', 'auth'))
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 align-items-center g-5">
        <div class="col">
            <div class="section-header">
                <h2 class="section-title text-capitalize mb-0">{{ translate('Reset Password', 'auth') }}</h2>
            </div>
            <div class="section-body">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
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
                    <x-captcha />
                    <button class="btn btn-primary btn-md w-100 fw-500">{{ translate('Reset', 'auth') }}</button>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="sign-img">
                <img src="{{ asset($themeSettings->authentication->reset_password_page_image) }}"
                    alt="{{ translate('Reset Password', 'auth') }}" />
            </div>
        </div>
    </div>
@endsection
