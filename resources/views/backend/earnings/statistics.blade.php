@extends('backend.layouts.grid')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Earnings Statistics'))
@section('container', 'container-max-xxl')
@section('content')
    @if (count($dates) > 0)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mb-4">
            <div class="col">
                <div class="vironeer-counter-card bg-secondary">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Downloads') }}</p>
                        <p class="vironeer-counter-card-number">{{ number_format($counters['downloads']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-green">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Downloads earnings') }}</p>
                        <p class="vironeer-counter-card-number">{{ earnings($counters['downloads_earnings']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-primary">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Referral earnings') }}</p>
                        <p class="vironeer-counter-card-number">{{ earnings($counters['referrals_earnings']) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header p-3 border-bottom-small">
                <form action="{{ request()->url() }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg-5">
                            <div class="select-group">
                                <div class="select-group-icon">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                                <select name="period" class="form-select radius">
                                    @foreach ($dates as $date)
                                        <option value="{{ $date->row }}"
                                            {{ request('period') == $date->row ? 'selected' : '' }}>
                                            {{ $date->format }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            @include('backend.partials.users-select')
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.earnings.statistics.index') }}"
                                class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="vironeer-box chart-bar mb-3">
                <div class="vironeer-box-header">
                    <p class="vironeer-box-header-title large">
                        {{ admin_trans('Statistics') }}
                    </p>
                </div>
                <div class="vironeer-box-body">
                    <div class="chart-bar">
                        <canvas height="400" id="earnings-statistics-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="table-responsive border-top">
                <table class="vironeer-normal-table table table-striped w-100 text-center">
                    <thead>
                        <tr>
                            <th>{{ admin_trans('Date') }}</th>
                            <th>{{ admin_trans('Downloads') }}</th>
                            <th>{{ admin_trans('Downloads Earnings') }}</th>
                            <th>{{ admin_trans('Daily CPM') }}</th>
                            <th>{{ admin_trans('Referrals Earnings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $key => $data)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ number_format($data['downloads']) }}</td>
                                <td>{{ earnings($data['download_earnings']) }}</td>
                                <td>{{ earnings($data['cpm']) }}</td>
                                <td>{{ earnings($data['referral_earnings']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @push('top_scripts')
            <script>
                "use strict";
                const chartsConfig = {!! json_encode([
                    'earnings' => [
                        'title' => admin_trans('Downloads'),
                        'labels' => $chart['labels'],
                        'data' => $chart['data'],
                        'max' => $chart['max'],
                    ],
                ]) !!};
            </script>
        @endpush
        @push('styles_libs')
            <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
            <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
            <script src="{{ asset('vendor/backend/js/charts.js') }}"></script>
        @endpush
    @else
        @include('backend.partials.empty', ['class' => 'empty-lg'])
    @endif
@endsection
