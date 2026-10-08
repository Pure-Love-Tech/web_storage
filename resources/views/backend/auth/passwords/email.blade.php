@extends('backend.layouts.auth')
@section('section', admin_trans('Admin'))
@section('title', admin_trans('Reset Password'))
@section('content')
    <h1 class="mb-0 h3">{{ admin_trans('Reset Password') }}</h1>
    <p class="card-text text-muted">
        {{ admin_trans('Enter the email address associated with your account and we will send a link to reset your password.') }}
    </p>
    <form action="{{ route('admin.password.reset') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ admin_trans('Email Address') }}</label>
            <input type="email" name="email" class="form-control form-control-lg" required />
        </div>
        <x-backend.captcha />
        <button class="btn btn-primary btn-lg d-block w-100">{{ admin_trans('Reset Password') }}</button>
    </form>
    <p class="mb-0 text-center text-muted mt-3">{{ admin_trans('Remember your password') }}? <a
            href="{{ route('admin.login') }}">{{ admin_trans('Login') }}</a></p>
@endsection
