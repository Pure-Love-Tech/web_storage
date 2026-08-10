@extends('themes.basic.layouts.auth')
@section('title', translate('2Fa Verification', 'auth'))
@section('content')
    <div class="row">
        <div class="col-lg-4 m-auto">
            <div class="section-header">
                <h2 class="section-title text-capitalize mb-0">{{ translate('2Fa Verification', 'auth') }}</h2>
            </div>
            <div class="section-body">
                <form action="{{ route('2fa.verify') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label form-label-lg">{{ translate('OTP Code', 'forms') }} : <span
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
                            <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                placeholder="••• •••" maxlength="6" required>
                        </div>
                    </div>
                    <x-captcha />
                    <button class="btn btn-primary btn-md w-100 fw-500">{{ translate('Continue', 'auth') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
