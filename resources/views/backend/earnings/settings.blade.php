@extends('backend.layouts.form')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Earnings Settings'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.earnings.settings') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Downloads Earnings') }}
            </div>
            <div class="card-body">
                <div class="row g-2 align-items-center mb-4">
                    <div class="col-lg-3">{{ admin_trans('Status') }} :</div>
                    <div class="col-lg-3">
                        <input type="checkbox" name="earnings[downloads][status]" data-toggle="toggle"
                            class="option-checkbox" data-id="3" data-on="{{ admin_trans('Enable') }}"
                            data-off="{{ admin_trans('Disable') }}"
                            {{ $settings->earnings->downloads->status ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Store Paid downloads only') }} :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="earnings[downloads][store]" data-toggle="toggle"
                                    data-on="{{ admin_trans('Yes') }}" data-off="{{ admin_trans('No') }}"
                                    {{ $settings->earnings->downloads->store ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-12  option-3 {{ !$settings->earnings->downloads->status ? 'd-none' : '' }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Paid Downloads Per Day') }} :
                            </div>
                            <div class="col-lg-9">
                                <input type="number" name="earnings[downloads][paid]" class="form-control" min="1"
                                    max="1000" value="{{ $settings->earnings->downloads->paid }}">
                                <div class="form-text">
                                    {{ admin_trans('The paid downloads per IP each day') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Referrals Earnings') }}
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Status') }} :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="earnings[referrals][status]" data-toggle="toggle"
                                    class="option-checkbox" data-id="4" data-on="{{ admin_trans('Enable') }}"
                                    data-off="{{ admin_trans('Disable') }}"
                                    {{ $settings->earnings->referrals->status ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 option-4 {{ !$settings->earnings->referrals->status ? 'd-none' : '' }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Referral Earnings Percentage') }} :
                            </div>
                            <div class="col-lg-9">
                                <div class="custom-input-group input-group">
                                    <input type="number" name="earnings[referrals][percentage]" class="form-control"
                                        min="1" max="100"
                                        value="{{ $settings->earnings->referrals->percentage }}">
                                    <span class="input-group-text"><strong><i class="fas fa-percent"></i></strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Bonus') }}
            </div>
            <div class="card-body">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-3">{{ admin_trans('New users bonus') }} :
                    </div>
                    <div class="col-lg-9">
                        <div class="custom-input-group input-group">
                            <input type="number" name="earnings[bonus][users]" class="form-control"
                                value="{{ $settings->earnings->bonus->users }}" step="any">
                            <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                        </div>
                        <div class="form-text">
                            {{ admin_trans('The new users will get the bonus after registring, the bonus will be added to the user downloads earnings.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                {{ admin_trans('Security') }}
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">{{ admin_trans('Proxy/VPN Detection') }} :</div>
                            <div class="col-lg-3">
                                <input type="checkbox" name="earnings[security][proxy_vpn_detection]" data-toggle="toggle"
                                    data-on="{{ admin_trans('Enable') }}" data-off="{{ admin_trans('Disable') }}"
                                    class="option-checkbox" data-id="1"
                                    {{ $settings->earnings->security->proxy_vpn_detection ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 option-1 {{ !$settings->earnings->security->proxy_vpn_detection ? 'd-none' : '' }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-lg-3">
                                {{ admin_trans('API Key') }} (<a href="https://trustip.io"
                                    target="_blank"><strong>Trustip.io</strong></a>) :</div>
                            <div class="col-lg-9">
                                <input type="text" name="earnings[security][trustip_api_key]" class="form-control"
                                    placeholder="{{ admin_trans('Enter trustip api key') }}"
                                    value="{{ demoMode() ? '' : $settings->earnings->security->trustip_api_key }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="row g-2">
                            <div class="col-lg-3">
                                <div class="mb-1">{{ admin_trans('Block Earnings for specific referrers') }} :</div>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="earnings[security][blocked_referrers]" class="form-control"
                                    placeholder="{{ admin_trans('example.com,example.com,example.com') }}" rows="4">{{ $settings->earnings->security->blocked_referrers }}</textarea>
                                <div class="form-text">
                                    {{ admin_trans('Enter the domains host only like "example.com" without any spaces and add commas between them.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
