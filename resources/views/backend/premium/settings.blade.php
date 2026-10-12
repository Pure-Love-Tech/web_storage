@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Premium Settings'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.settings') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                {{ admin_trans('Subscriptions') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-5">
                        <label class="form-label">{{ admin_trans('Subscription expire notification') }} </label>
                        <input type="checkbox" name="subscription[expire_notification]" data-toggle="toggle"
                            {{ $settings->subscription->expire_notification ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ admin_trans('Delete expired subscription data') }}</label>
                        <select name="subscription[delete_expired]" class="form-select">
                            <option value="0" {{ $settings->subscription->delete_expired == 0 ? 'selected' : '' }}>
                                {{ admin_trans('Never') }}</option>
                            <option value="3" {{ $settings->subscription->delete_expired == 3 ? 'selected' : '' }}>
                                {{ admin_trans('After 3 days') }}</option>
                            <option value="7" {{ $settings->subscription->delete_expired == 7 ? 'selected' : '' }}>
                                {{ admin_trans('After 7 days') }}</option>
                            <option value="14" {{ $settings->subscription->delete_expired == 14 ? 'selected' : '' }}>
                                {{ admin_trans('After 14 days') }}</option>
                            <option value="30" {{ $settings->subscription->delete_expired == 30 ? 'selected' : '' }}>
                                {{ admin_trans('After 1 Month') }}</option>
                            <option value="60" {{ $settings->subscription->delete_expired == 60 ? 'selected' : '' }}>
                                {{ admin_trans('After 3 Months') }}</option>
                            <option value="120" {{ $settings->subscription->delete_expired == 120 ? 'selected' : '' }}>
                                {{ admin_trans('After 6 Months') }}</option>
                            <option value="365" {{ $settings->subscription->delete_expired == 365 ? 'selected' : '' }}>
                                {{ admin_trans('After 1 Year') }}</option>
                            <option value="730" {{ $settings->subscription->delete_expired == 730 ? 'selected' : '' }}>
                                {{ admin_trans('After 2 Years') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
