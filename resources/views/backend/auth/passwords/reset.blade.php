@extends('backend.layouts.auth')
@section('section', admin_trans('Admin'))
@section('title', admin_trans('Reset Password'))
@section('content')
    <h1 class="mb-0 h3">{{ admin_trans('Reset Password') }}</h1>
    <p class="card-text text-muted">
        {{ admin_trans('Enter the email address and a new password to start using your account.') }}</p>
    <form action="{{ route('admin.password.reset.change') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />
        <div class="mb-3">
            <label class="form-label">{{ admin_trans('Email Address') }}</label>
            <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control form-control-lg"
                required />
        </div>
        <div class="mb-3">
            <label class="form-label">{{ admin_trans('Password') }}</label>
            <input type="password" name="password" class="form-control form-control-lg" required />
        </div>
        <div class="mb-3">
            <label class="form-label">{{ admin_trans('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" class="form-control form-control-lg" required />
        </div>
        <x-backend.captcha />
        <button class="btn btn-primary btn-lg d-block w-100">{{ admin_trans('Reset Password') }}</button>
    </form>
    <p class="mb-0 text-center text-muted mt-3">{{ admin_trans('Remember your password') }}? <a
            href="{{ route('admin.login') }}">{{ admin_trans('Login') }}</a></p>
@endsection
