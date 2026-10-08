@extends('backend.layouts.application')
@section('title', admin_trans('Dashboard'))
@section('access', admin_trans('Quick Access'))
@section('container', 'container-max-xxl')
@section('content')
    @if (!$settings->smtp->status)
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ admin_trans('SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.') }}
            <a href="{{ route('admin.settings.smtp.index') }}">{{ admin_trans('Take Action') }}</a>
        </div>
    @endif
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-lg-1">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Total Users Earnings') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['earnings']['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-c-5">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('This Month Earnings') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['earnings']['monthly']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-4">
            <div class="vironeer-counter-card bg-lg-9">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Today Earnings') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['earnings']['daily']) }}</p>
                </div>
            </div>
        </div>
    </div>
    @if (licenseType(2))
        <div class="row g-3 mb-3">
            <div class="col-12 col-lg-6 col-xxl-4">
                <div class="vironeer-counter-card bg-c2">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Total Income') }}</p>
                        <p class="vironeer-counter-card-number">{{ priceSymbol($counters['income']['total']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xxl-4">
                <div class="vironeer-counter-card bg-c3">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Current Month Income') }}</p>
                        <p class="vironeer-counter-card-number">{{ priceSymbol($counters['income']['monthly']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xxl-4">
                <div class="vironeer-counter-card bg-c4">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Today Income') }}</p>
                        <p class="vironeer-counter-card-number">{{ priceSymbol($counters['income']['daily']) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-c27">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Total Withdrawals') }}</p>
                    <p class="vironeer-counter-card-number">{{ formatNumber($counters['withdrawals']['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-c12">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Total Withdrawn') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['withdrawals']['total_amount']) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-4">
            <div class="vironeer-counter-card bg-c17">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Pending Withdrawn') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['withdrawals']['pending_amount']) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-c-1">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Total Users') }}</p>
                    <p class="vironeer-counter-card-number">{{ formatNumber($counters['users']['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-primary">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-folder-open"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Total Files') }}</p>
                    <p class="vironeer-counter-card-number">{{ formatNumber($counters['files']['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-secondary">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-hard-drive"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Used Space') }}</p>
                    <p class="vironeer-counter-card-number">{{ formatBytes($counters['files']['used_space']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8 col-xxl-8">
            <div class="card h-100">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">
                            {{ admin_trans('Users Statistics For This Week') }}
                        </p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.members.users.index') }}">{{ admin_trans('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="chart-bar">
                            <canvas height="380" id="dashboard-users-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-4">
            <div class="card h-100">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ admin_trans('Recently registered') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.members.users.index') }}">{{ admin_trans('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @forelse ($users as $user)
                                <div class="vironeer-random-list">
                                    <div class="vironeer-random-list-cont">
                                        <a class="vironeer-random-list-img" href="#">
                                            <img src="{{ asset($user->avatar) }}" />
                                        </a>
                                        <div class="vironeer-random-list-info">
                                            <div>
                                                <a class="vironeer-random-list-title fs-exact-14"
                                                    href="{{ route('admin.members.users.edit', $user->id) }}">
                                                    {{ $user->name }}
                                                </a>
                                                <p class="vironeer-random-list-text mb-0">
                                                    {{ $user->created_at->diffforhumans() }}
                                                </p>
                                            </div>
                                            <div class="vironeer-random-list-action d-none d-lg-block">
                                                <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('backend.partials.empty')
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large">
                            {{ admin_trans('Uploads Statistics For ') }}
                            ({{ app(\Carbon\Carbon::class)->now()->format('F') }})
                        </p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.files.users.index') }}">{{ admin_trans('Users files') }}</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.files.visitors.index') }}">{{ admin_trans('Visitors files') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="chart-bar">
                            <canvas height="400" id="dashboard-uploads-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">{{ admin_trans('Login Statistics - Browsers') }}
                        </p>
                        <small class="text-muted ms-auto">({{ app(\Carbon\Carbon::class)->now()->format('F') }})</small>
                    </div>
                    @if (count($charts['logs']) > 0)
                        <div class="vironeer-box-body">
                            <div class="chart-bar mt-4">
                                <canvas id="dashboard-browsers-chart"></canvas>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            @include('backend.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">
                            {{ admin_trans('Login Statistics - Operating Systems') }}
                        </p>
                        <small class="text-muted ms-auto">({{ app(\Carbon\Carbon::class)->now()->format('F') }})</small>
                    </div>
                    @if (count($charts['logs']) > 0)
                        <div class="vironeer-box-body">
                            <div class="chart-bar mt-4">
                                <canvas id="dashboard-os-chart"></canvas>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            @include('backend.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">{{ admin_trans('Login Statistics - Countries') }}
                        </p>
                        <small class="text-muted ms-auto">({{ app(\Carbon\Carbon::class)->now()->format('F') }})</small>
                    </div>
                    @if (count($charts['logs']) > 0)
                        <div class="vironeer-box-body">
                            <div class="chart-bar mt-4">
                                <canvas id="dashboard-countries-chart"></canvas>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            @include('backend.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('top_scripts')
        <script>
            "use strict";
            const chartsConfig = {!! json_encode([
                'users' => [
                    'title' => admin_trans('Users'),
                    'labels' => $charts['users']['labels'],
                    'data' => $charts['users']['data'],
                    'max' => $charts['users']['max'],
                ],
                'uploads' => [
                    'title' => admin_trans('Uploaded files'),
                    'labels' => $charts['uploads']['labels'],
                    'data' => $charts['uploads']['data'],
                    'max' => $charts['uploads']['max'],
                ],
                'logs' => $charts['logs'],
            ]) !!};
        </script>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('vendor/backend/js/charts.js') }}"></script>
    @endpush
@endsection
