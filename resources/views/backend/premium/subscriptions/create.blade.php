@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Subscriptions') . ' | ' . admin_trans('Add'))
@section('back', route('admin.premium.subscriptions.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.subscriptions.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                {{ admin_trans('Subscription Details') }}
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('User') }}</label>
                    @include('backend.partials.users-select')
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ admin_trans('Interval') }}</label>
                    <select name="plan_id" class="form-select selectpicker" title="{{ admin_trans('Choose') }}"
                        data-live-search="true">
                        @foreach ($premiumPlans as $premiumPlan)
                            <option value="{{ $premiumPlan->id }}">
                                {{ $premiumPlan->plan->name }}
                                ({{ $premiumPlan->interval }}
                                {{ $premiumPlan->interval == 1 ? admin_trans('day') : admin_trans('days') }})
                            </option>
                        @endforeach
                    </select>
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
