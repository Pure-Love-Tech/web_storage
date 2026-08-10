@extends('backend.layouts.grid')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Earnings Records'))
@section('container', 'container-max-xxl')
@section('content')
    @if (count($dates) > 0)
        <div class="card mb-4">
            <div class="card-header p-3 border-bottom-small">
                <form action="{{ request()->url() }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg-5">
                            <select name="period" class="form-select selectpicker" title="{{ admin_trans('Period') }}">
                                @foreach ($dates as $date)
                                    <option value="{{ $date->row }}"
                                        {{ request('period') == $date->row ? 'selected' : '' }}>
                                        {{ $date->format }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-3">
                            @include('backend.partials.users-select')
                        </div>
                        <div class="col-12 col-lg-2">
                            <select name="source" class="form-select selectpicker" title="{{ admin_trans('Source') }}"
                                data-live-search="true">
                                <option value="download">{{ admin_trans('Download') }}</option>
                                <option value="referral">{{ admin_trans('Referral') }}</option>
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.earnings.records.index') }}"
                                class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th>{{ admin_trans('ID') }}</th>
                                <th>{{ admin_trans('User') }}</th>
                                <th>{{ admin_trans('IP Address') }}</th>
                                <th>{{ admin_trans('Country') }}</th>
                                <th>{{ admin_trans('Payout Rate') }}</th>
                                <th>{{ admin_trans('Earnings') }}</th>
                                <th class="text-center">{{ admin_trans('Source') }}</th>
                                <th class="text-center">{{ admin_trans('Referer domain') }}</th>
                                <th class="text-center">{{ admin_trans('Status') }}</th>
                                <th class="text-center">{{ admin_trans('Status Reason') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('admin.earnings.records.show', $record->id) }}">#{{ $record->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $record->user->id) }}"
                                            class="text-dark"><i
                                                class="fa fa-user me-2"></i>{{ $record->user->username }}</a>
                                    </td>
                                    <td>
                                        @if (!demoMode())
                                            @if ($record->ip)
                                                <a href="{{ route('admin.members.users.logsbyip', $record->ip) }}"><i
                                                        class="fa-solid fa-location-dot me-2"></i>{{ shorterText($record->ip, 20) }}</a>
                                            @else
                                                <span>--</span>
                                            @endif
                                        @else
                                            <span>{{ admin_trans('Hidden in demo') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $record->country ?? '--' }}</td>
                                    <td>{{ $record->payout_rate ? priceSymbol($record->payout_rate) : '--' }}</td>
                                    <td>
                                        <strong
                                            class="{{ $record->earnings > 0 ? 'text-success' : 'text-dark' }}">{{ earnings($record->earnings) }}</strong>
                                    </td>
                                    <td class="text-center">{{ ucfirst($record->earning_source) }}</td>
                                    <td class="text-center">{{ $record->referer_domain ?? '--' }}</td>
                                    <td class="text-center">
                                        @if ($record->isValid())
                                            <span class="badge bg-green">{{ admin_trans('Valid') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ admin_trans('Invalid') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $record->status_reason ?? '--' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.earnings.records.show', $record->id) }}"
                                            class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $records->links() }}
        @push('styles_libs')
            <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        @endpush
    @else
        @include('backend.partials.empty', ['class' => 'empty-lg'])
    @endif
@endsection
