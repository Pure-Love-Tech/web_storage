@extends('backend.layouts.form')
@section('title', admin_trans('SMTP'))
@section('section', admin_trans('Settings'))
@section('container', 'container-max-lg')
@section('content')
    @if ($settings->smtp->status)
        <div class="note note-warning">
            <h5>{{ admin_trans('Note!!') }}</h5>
            {{ admin_trans('If your SMTP is not working some of pages that using it, for example, (the password reset, email verification, etc..), will give an error 500, meaning that the mail cannot be sent, so make sure to test the mail sending, before start using it.') }}
        </div>
    @endif
    <form id="vironeer-submited-form" action="{{ route('admin.settings.smtp.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                {{ admin_trans('SMTP details') }}
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Status :') }} </label>
                    <div class="col col-lg-3">
                        <input type="checkbox" name="smtp[status]" data-toggle="toggle"
                            @if ($settings->smtp->status) checked @endif>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Mail mailer :') }} </label>
                    <div class="col">
                        <select name="smtp[mailer]" class="form-select">
                            <option value="smtp" @if ($settings->smtp->mailer == 'mail_mailer') selected @endif>
                                {{ admin_trans('SMTP') }}
                            </option>
                            <option value="sendmail" @if ($settings->smtp->mailer == 'sendmail') selected @endif>
                                {{ admin_trans('SENDMAIL') }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Mail Host :') }} </label>
                    <div class="col">
                        <input type="text" name="smtp[host]" class="remove-spaces form-control"
                            value="{{ $settings->smtp->host }}" placeholder="{{ admin_trans('Enter mail host') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Mail Port :') }} </label>
                    <div class="col">
                        <input type="text" name="smtp[port]" class="remove-spaces form-control"
                            value="{{ $settings->smtp->port }}" placeholder="{{ admin_trans('Enter mail port') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Mail username :') }} </label>
                    <div class="col">
                        <input type="text" name="smtp[username]" class="form-control remove-spaces"
                            value="{{ $settings->smtp->username }}" placeholder="{{ admin_trans('Enter username') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Mail password :') }} </label>
                    <div class="col">
                        <input type="password" name="smtp[password]" class="form-control"
                            value="{{ $settings->smtp->password }}" placeholder="{{ admin_trans('Enter password') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('Mail encryption :') }}
                    </label>
                    <div class="col">
                        <select name="smtp[encryption]" class="form-select">
                            <option value="tls" @if ($settings->smtp->encryption == 'tls') selected @endif>
                                {{ admin_trans('TLS') }}
                            </option>
                            <option value="ssl" @if ($settings->smtp->encryption == 'ssl') selected @endif>
                                {{ admin_trans('SSL') }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('From email :') }} </label>
                    <div class="col">
                        <input type="text" name="smtp[from_email]" class="remove-spaces form-control"
                            value="{{ $settings->smtp->from_email }}" placeholder="{{ admin_trans('Enter from email') }}">
                    </div>
                </div>
                <div class="row">
                    <label class="form-label col-12 col-lg-3 col-form-label">{{ admin_trans('From name :') }} </label>
                    <div class="col">
                        <input type="text" name="smtp[from_name]" class="remove-spaces form-control"
                            value="{{ $settings->smtp->from_name }}" placeholder="{{ admin_trans('Enter from name') }}">
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if ($settings->smtp->status)
        <div class="card mt-4">
            <div class="card-header">
                {{ admin_trans('Testing') }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.smtp.test') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-lg-auto">
                            <label class="form-label">{{ admin_trans('E-mail Address') }}</label>
                        </div>
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="john@example.com"
                                value="{{ old('email') ??auth()->guard('admin')->user()->email }}">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success">{{ admin_trans('Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
