@extends('backend.layouts.grid')
@section('title', admin_trans('File statistics'))
@section('container', 'container-max-xxl')
@section('back', route('admin.files.users.show', $fileEntry->id))
@section('content')
    <div class="card mb-3">
        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.files.users.show', $fileEntry->id) }}">
                                {!! $fileEntry->getFileIcon('fa-2x') !!}
                            </a>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <a href="{{ route('admin.files.users.show', $fileEntry->id) }}" class="text-dark">
                                <h5 class="mb-1">{{ shorterText($fileEntry->getFullName(), 50) }}</h5>
                                <p class="mb-0 text-muted">{{ dateFormat($fileEntry->created_at) }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="select-group">
                        <div class="select-group-icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <select id="period-select" class="form-select">
                            @foreach ($dates as $date)
                                <option
                                    value="{{ route('admin.files.users.statistics', [$fileEntry->id, 'period=' . $date['row']]) }}"
                                    @selected(request('period') == $date['row'])>
                                    {{ $date['format'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 g-3 mb-4">
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
                    <p class="vironeer-counter-card-title">{{ admin_trans('Earnings') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['earnings']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
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
                        <th>{{ admin_trans('Earnings') }}</th>
                        <th>{{ admin_trans('Daily CPM') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tableData as $key => $data)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ number_format($data['downloads']) }}</td>
                            <td>{{ earnings($data['earnings']) }}</td>
                            <td>{{ earnings($data['cpm']) }}</td>
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
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('vendor/backend/js/charts.js') }}"></script>
    @endpush
@endsection
