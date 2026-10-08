@extends('themes.basic.user.layouts.app')
@section('back', route('user.files.index'))
@section('title', translate('File statistics', 'files'))
@section('content')
    <div class="card-v mb-3 py-3">
        <div class="row row-cols-1 row-cols-md-auto align-items-center justify-content-between g-2">
            <div class="col">
                <div class="file-name file-name-ellipsis">
                    <div class="file-name-icon">
                        {!! $fileEntry->getFileIcon('fa-2x') !!}
                    </div>
                    <div class="file-name-info">
                        <p class="file-name-title">{{ $fileEntry->getFullName() }}</p>
                        <p class="file-name-text text-muted">{{ dateFormat($fileEntry->created_at) }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dash-select">
                    <div class="dash-select-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                    <select id="period-select" class="form-select radius">
                        @foreach ($dates as $date)
                            <option value="{{ route('user.files.statistics', [$fileEntry->id, 'period=' . $date['key']]) }}"
                                @selected(request('period') == $date['key'])>
                                {{ $date['value'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 row-cols-xxl-2 g-3 mb-4">
        <div class="col">
            <div class="counter counter-secondary">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Downloads', 'files') }}</h6>
                        <p class="counter-number">{{ number_format($counters['downloads']) }}</p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 15V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18L4 15M8 11L12 15M12 15L16 11M12 15V3"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-green">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Earnings', 'files') }}</h6>
                        <p class="counter-number">{{ earnings($counters['earnings']) }}</p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.5 13.75C9.5 14.72 10.25 15.5 11.17 15.5H13.05C13.85 15.5 14.5 14.82 14.5 13.97C14.5 13.06 14.1 12.73 13.51 12.52L10.5 11.47C9.91 11.26 9.51001 10.94 9.51001 10.02C9.51001 9.17999 10.16 8.48999 10.96 8.48999H12.84C13.76 8.48999 14.51 9.26999 14.51 10.24"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 7.5V16.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M17 3V7H21" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M22 2L17 7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-v mb-3">
        <h5 class="mb-3">{{ translate('Statistics', 'files') }}</h5>
        <div class="dash-chart mb-3">
            <canvas id="statistics-chart"></canvas>
        </div>
        <div class="dash-table dash-table-hiehgt">
            <table class="table text-center table-borderless">
                <thead>
                    <tr>
                        <th>{{ translate('Date', 'files') }}</th>
                        <th>{{ translate('Downloads', 'files') }}</th>
                        <th>{{ translate('Earnings', 'files') }}</th>
                        <th>{{ translate('Daily CPM', 'files') }}</th>
                    </tr>
                </thead>
                <tbody class="text-muted">
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
    <div class="card-v">
        <h5 class="mb-3">{{ translate('Countries', 'files') }}</h5>
        <div class="row gx-4 gy-3">
            <div class="col-xl-7">
                <div id="countries-downloads-statistics" class="w-100"></div>
            </div>
            <div class="col-xl-5">
                <div class="main-table">
                    <div class="dash-countries-card dash-table">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr class="text-start">
                                    <th>{{ translate('Country', 'files') }}</th>
                                    <th>{{ translate('Downloads', 'files') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-muted text-start">
                                @forelse ($tableCountriesDownloads as $tableCountryDownload)
                                    <tr>
                                        <td>{{ $tableCountryDownload->country }}</td>
                                        <td>{{ $tableCountryDownload->downloads }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            <div class="py-2 text-center">{{ translate('No data found', 'files') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
    @push('top_scripts')
        @php
            $chartConfig = [
                'line' => [
                    'title' => translate('Downloads', 'files'),
                    'labels' => $chart['labels'],
                    'data' => $chart['data'],
                    'max' => $chart['max'],
                ],
                'geo' => [
                    'data' => [],
                ],
            ];
            $chartConfig['geo']['data'][] = ['Country', translate('Downloads', 'files')];
            if (!$geoCountriesDownloads->isEmpty()) {
                foreach ($geoCountriesDownloads as $geoCountryDownload) {
                    $chartConfig['geo']['data'][] = [$geoCountryDownload->country, intval($geoCountryDownload->downloads)];
                }
            }
        @endphp
        <script>
            "use strict";
            const chartConfig = @json($chartConfig);
        </script>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="{{ theme_asset('assets/js/charts.js') }}"></script>
    @endpush
@endsection
