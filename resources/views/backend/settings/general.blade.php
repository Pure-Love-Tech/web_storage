@extends('backend.layouts.form')
@section('section', admin_trans('Settings'))
@section('title', admin_trans('General Information'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.general.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('General') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Site Name') }}</label>
                        <input type="text" name="general[site_name]" class="form-control"
                            value="{{ $settings->general->site_name }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Site URL') }}</label>
                        <input type="text" name="general[site_url]" class="form-control"
                            value="{{ $settings->general->site_url }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Contact email') }}</label>
                        <input type="text" name="general[contact_email]" class="form-control"
                            value="{{ $settings->general->contact_email }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Terms of service') }} : <small
                                class="text-muted">({{ admin_trans('For registration and GDPR cookie') }})</small></label>
                        <input type="text" name="general[terms_of_service_link]" class="form-control"
                            value="{{ $settings->general->terms_of_service_link }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Date format') }} </label>
                        <select name="general[date_format]" class="form-select  selectpicker" data-live-search="true"
                            title="{{ admin_trans('Date format') }}">
                            @foreach (\App\Models\Settings::dateFormats() as $formatKey => $formatValue)
                                <option value="{{ $formatKey }}"
                                    {{ $formatKey == $settings->general->date_format ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::now()->format($formatValue) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Timezone') }} </label>
                        <select name="general[timezone]" class="form-select selectpicker" data-live-search="true"
                            title="{{ admin_trans('Timezone') }}">
                            @foreach (\App\Models\Settings::timezones() as $timezoneKey => $timezoneValue)
                                <option value="{{ $timezoneKey }}"
                                    {{ $timezoneKey == $settings->general->timezone ? 'selected' : '' }}>
                                    {{ $timezoneValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Default Captcha') }}</label>
                        <select name="general[default_captcha]" class="form-select">
                            <option value="" {{ !$settings->general->default_captcha ? 'selected' : '' }}>
                                {{ admin_trans('None') }}</option>
                            <option value="google_recaptcha"
                                {{ $settings->general->default_captcha == 'google_recaptcha' ? 'selected' : '' }}>
                                {{ admin_trans('Google reCaptcha') }}</option>
                            <option value="hcaptcha"
                                {{ $settings->general->default_captcha == 'hcaptcha' ? 'selected' : '' }}>
                                {{ admin_trans('hCaptcha') }}</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">{{ admin_trans('Adblock Detection') }}
                        </label>
                        <select name="general[adblock_detection]" class="form-select">
                            <option value="" {{ !$settings->general->adblock_detection ? 'selected' : '' }}>
                                {{ admin_trans('None') }}
                            </option>
                            <option value="1" {{ $settings->general->adblock_detection == 1 ? 'selected' : '' }}>
                                {{ admin_trans('All pages') }}
                            </option>
                            <option value="2" {{ $settings->general->adblock_detection == 2 ? 'selected' : '' }}>
                                {{ admin_trans('Download page only') }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Currency') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-4">
                        <label class="form-label">{{ admin_trans('Currency Code') }}</label>
                        <input type="text" name="currency[code]" class="form-control"
                            value="{{ $settings->currency->code }}" placeholder="{{ admin_trans('USD') }}" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ admin_trans('Currency Symbol') }}</label>
                        <input type="text" name="currency[symbol]" class="form-control"
                            value="{{ $settings->currency->symbol }}" placeholder="$" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ admin_trans('Currency position') }}</label>
                        <select name="currency[position]" class="form-select">
                            <option value="1" {{ $settings->currency->position == 1 ? 'selected' : '' }}>
                                {{ admin_trans('Before price') }}</option>
                            <option value="2" {{ $settings->currency->position == 2 ? 'selected' : '' }}>
                                {{ admin_trans('After price') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Number of Decimals for Earnings') }}</label>
                        <input type="number" name="currency[earnings_decimals]" class="form-control" max="9"
                            value="{{ $settings->currency->earnings_decimals }}" placeholder="0" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Number of Decimals for Prices') }}</label>
                        <input type="number" name="currency[prices_decimals]" class="form-control" max="9"
                            value="{{ $settings->currency->prices_decimals }}" placeholder="0" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ admin_trans('Actions') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Registration') }} </label>
                        <input type="checkbox" name="actions[registration_status]" data-toggle="toggle"
                            {{ $settings->actions->registration_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Email Verification') }} </label>
                        <input type="checkbox" name="actions[email_verification_status]" data-toggle="toggle"
                            {{ $settings->actions->email_verification_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Block disposable emails addresses') }} </label>
                        <input type="checkbox" name="actions[disposable_emails_status]" data-toggle="toggle"
                            data-on="{{ admin_trans('Yes') }}" data-off="{{ admin_trans('No') }}"
                            {{ $settings->actions->disposable_emails_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Force SSL') }} </label>
                        <input type="checkbox" name="actions[force_ssl_status]" data-toggle="toggle"
                            data-on="{{ admin_trans('Yes') }}" data-off="{{ admin_trans('No') }}"
                            {{ $settings->actions->force_ssl_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('GDPR Cookie') }} </label>
                        <input type="checkbox" name="actions[gdpr_cookie_status]" data-toggle="toggle"
                            {{ $settings->actions->gdpr_cookie_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Include language code in URL') }} </label>
                        <input type="checkbox" name="actions[language_type]" data-toggle="toggle"
                            data-on="{{ admin_trans('Yes') }}" data-off="{{ admin_trans('No') }}"
                            {{ $settings->actions->language_type ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Language menu') }} </label>
                        <input type="checkbox" name="actions[language_menu]" data-toggle="toggle"
                            data-on="{{ admin_trans('Show') }}" data-off="{{ admin_trans('Hide') }}"
                            {{ $settings->actions->language_menu ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ admin_trans('Website Blog') }} </label>
                        <input type="checkbox" name="actions[blog_status]" data-toggle="toggle"
                            {{ $settings->actions->blog_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-4 col-xl-4">
                        <label class="form-label">{{ admin_trans('Contact Page') }} </label>
                        <input type="checkbox" name="actions[contact_page]" data-toggle="toggle"
                            data-on="{{ admin_trans('Enable') }}" data-off="{{ admin_trans('Disable') }}"
                            {{ $settings->actions->contact_page ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-4 col-xl-4">
                        <label class="form-label">{{ admin_trans('Payout Rates Page') }} </label>
                        <input type="checkbox" name="actions[payout_rates_page]" data-toggle="toggle"
                            data-on="{{ admin_trans('Visible') }}" data-off="{{ admin_trans('Hidden') }}"
                            {{ $settings->actions->payout_rates_page ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-4 col-xl-4">
                        <label class="form-label">{{ admin_trans('Payment Proof Page') }} </label>
                        <input type="checkbox" name="actions[payment_proof_page]" data-toggle="toggle"
                            data-on="{{ admin_trans('Visible') }}" data-off="{{ admin_trans('Hidden') }}"
                            {{ $settings->actions->payment_proof_page ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            $(function() {
                $('.vironeer-color-picker').colorpicker();
            });
        </script>
    @endpush
@endsection
