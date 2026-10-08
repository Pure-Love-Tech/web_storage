@extends('themes.basic.user.layouts.app')
@section('title', translate('Dashboard', 'dashboard'))
@section('content')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 row-cols-xxl-4 g-3 mb-4">
        <div class="col">
            <div class="counter counter-secondary">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Downloads', 'dashboard') }}</h6>
                        <p class="counter-number">{{ number_format($counters['downloads']) }}</p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 15V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18L4 15M8 11L12 15M12 15L16 11M12 15V3"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-green">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Downloads Earnings', 'dashboard') }}</h6>
                        <p class="counter-number">
                            {{ earnings($counters['earnings']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.5 13.75C9.5 14.72 10.25 15.5 11.17 15.5H13.05C13.85 15.5 14.5 14.82 14.5 13.97C14.5 13.06 14.1 12.73 13.51 12.52L10.5 11.47C9.91 11.26 9.51001 10.94 9.51001 10.02C9.51001 9.17999 10.16 8.48999 10.96 8.48999H12.84C13.76 8.48999 14.51 9.26999 14.51 10.24"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 7.5V16.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 3V7H21" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 2L17 7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-yellow">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Average CPM', 'dashboard') }}</h6>
                        <p class="counter-number">
                            {{ earnings($counters['cpm']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="Interface / Chart_Line">
                                <path id="Vector"
                                    d="M3 15.0002V16.8C3 17.9201 3 18.4798 3.21799 18.9076C3.40973 19.2839 3.71547 19.5905 4.0918 19.7822C4.5192 20 5.07899 20 6.19691 20H21.0002M3 15.0002V5M3 15.0002L6.8534 11.7891L6.85658 11.7865C7.55366 11.2056 7.90288 10.9146 8.28154 10.7964C8.72887 10.6567 9.21071 10.6788 9.64355 10.8584C10.0105 11.0106 10.3323 11.3324 10.9758 11.9759L10.9822 11.9823C11.6357 12.6358 11.9633 12.9635 12.3362 13.1153C12.7774 13.2951 13.2685 13.3106 13.7207 13.1606C14.1041 13.0334 14.4542 12.7275 15.1543 12.115L21 7"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-primary">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Referral Earnings', 'dashboard') }}</h6>
                        <p class="counter-number">
                            {{ earnings($counters['referral_earnings']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19 14C21.2091 14 23 16 23 17.5C23 18.3284 22.3284 19 21.5 19H21M17 11C18.6569 11 20 9.65685 20 8C20 6.34315 18.6569 5 17 5M5 14C2.79086 14 1 16 1 17.5C1 18.3284 1.67157 19 2.5 19H3M7 11C5.34315 11 4 9.65685 4 8C4 6.34315 5.34315 5 7 5M16.5 19H7.5C6.67157 19 6 18.3284 6 17.5C6 15 9 14 12 14C15 14 18 15 18 17.5C18 18.3284 17.3284 19 16.5 19ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-v mb-3">
        <h5 class="mb-3">{{ translate('Statistics', 'dashboard') }}</h5>
        <div class="dash-chart">
            <canvas id="statistics-chart"></canvas>
        </div>
    </div>
    <div class="card-v">
        <div class="dash-table dash-table-hiehgt">
            <table class="table text-center table-borderless">
                <thead>
                    <tr>
                        <th>{{ translate('Date', 'dashboard') }}</th>
                        <th>{{ translate('Downloads', 'dashboard') }}</th>
                        <th>{{ translate('Downloads Earnings', 'dashboard') }}</th>
                        <th>{{ translate('Daily CPM', 'dashboard') }}</th>
                        <th>{{ translate('Referrals Earnings', 'dashboard') }}</th>
                    </tr>
                </thead>
                <tbody class="text-muted">
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
            const chartConfig = {!! json_encode([
                'line' => [
                    'title' => translate('Downloads', 'dashboard'),
                    'labels' => $chart['labels'],
                    'data' => $chart['data'],
                    'max' => $chart['max'],
                ],
            ]) !!};
        </script>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ theme_asset('assets/js/charts.js') }}"></script>
    @endpush
@endsection
