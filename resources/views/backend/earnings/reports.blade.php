@extends('backend.layouts.grid')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Earnings Reports'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="card mb-4">
        <div class="card-body p-4">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">{{ admin_trans('From') }}</label>
                            </div>
                            <div class="col">
                                <input type="date" name="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">{{ admin_trans('To') }}</label>
                            </div>
                            <div class="col">
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">{{ admin_trans('User') }}</label>
                            </div>
                            <div class="col">
                                @include('backend.partials.users-select')
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.earnings.reports.index') }}"
                            class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (!$empty)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 g-3 mb-4">
            <div class="col">
                <div class="vironeer-counter-card bg-secondary">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Total Downloads') }}</p>
                        <p class="vironeer-counter-card-number">{{ formatNumber($counters['total_downloads']) }}</p>
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
                        <p class="vironeer-counter-card-title">{{ admin_trans('Total Downloads earnings') }}</p>
                        <p class="vironeer-counter-card-number">{{ earnings($counters['total_downloads_earnings']) }}
                        </p>
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
                        <p class="vironeer-counter-card-title">{{ admin_trans('Total Referral earnings') }}</p>
                        <p class="vironeer-counter-card-number">{{ earnings($counters['total_referrals_earnings']) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-c12">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Total Withdrawn Amount') }}</p>
                        <p class="vironeer-counter-card-number">{{ earnings($counters['total_withdrawn_amount']) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white border-bottom-0">
                <i class="fa-solid fa-earth-americas me-1"></i>
                {{ admin_trans('Countries') }}
            </div>
            <div class="card-body p-4">
                <div class="row alig-items-center g-4">
                    <div class="col-lg-12 col-xxl-8">
                        <div class="p-4">
                            <div id="countries-downloads-statistics" class="w-100"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xxl-4">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr class="text-start bg-light">
                                    <th>{{ admin_trans('Country') }}</th>
                                    <th>{{ admin_trans('Downloads') }}</th>
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
                                            <div class="py-2 text-center">{{ admin_trans('No data found') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-secondary text-white border-bottom-0">
                <i class="fa-regular fa-folder-open me-1"></i>
                {{ admin_trans('Files') }}
            </div>
            <div class="table-responsive">
                <table class="vironeer-normal-table table w-100">
                    <thead>
                        <tr>
                            <th>{{ admin_trans('File name') }}</th>
                            <th class="text-center">{{ admin_trans('Downloads') }}</th>
                            <th class="text-center">{{ admin_trans('Earnings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filesData as $data)
                            <tr>
                                <td>
                                    @if ($data->file_entry)
                                        <a
                                            href="{{ route('admin.files.users.show', $data->file_entry->id) }}">{{ $data->file_entry->getFullName() }}</a>
                                    @else
                                        <span>{{ $data->file_entry_details->name }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ number_format($data->total_downloads) }}</td>
                                <td class="text-center">{{ earnings($data->total_earnings) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="py-2 text-center">{{ admin_trans('No data found') }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $filesData->links() }}
        @push('top_scripts')
            @php
                $chartConfig[] = ['Country', admin_trans('Downloads')];
                if (!$geoCountriesDownloads->isEmpty()) {
                    foreach ($geoCountriesDownloads as $geoCountryDownload) {
                        $chartConfig[] = [$geoCountryDownload->country, intval($geoCountryDownload->downloads)];
                    }
                }
            @endphp
            <script>
                "use strict";
                const geoChartConfig = @json($chartConfig);
            </script>
        @endpush
    @else
        <div class="card">
            <div class="card-body">
                @include('backend.partials.empty', ['class' => 'empty-lg'])
            </div>
        </div>
    @endif
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="{{ asset('vendor/backend/js/charts.js') }}"></script>
    @endpush
@endsection
