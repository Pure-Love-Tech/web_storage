@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Subscriptions') . ' | #' . $subscription->id)
@section('back', route('admin.premium.subscriptions.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            {{ admin_trans('User Details') }}
        </div>
        <div class="card-body text-center p-4">
            <img src="{{ asset($subscription->user->avatar) }}" alt="{{ $subscription->name }}" class="rounded-circle mb-3">
            <h4 class="mb-3">{{ $subscription->user->name }}</h4>
            <a href="{{ route('admin.members.users.edit', $subscription->user->id) }}"
                class="btn btn-primary">{{ admin_trans('View Account details') }}</a>
        </div>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.premium.subscriptions.update', $subscription->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                {{ admin_trans('Subscription Details') }}
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label">{{ admin_trans('Expiry at') }}</label>
                    <input type="datetime-local" step="any" name="expiry_at" class="form-control"
                        value="{{ app(\Carbon\Carbon::class)->parse($subscription->expiry_at)->format('Y-m-d\TH:i:s') }}"
                        required>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
