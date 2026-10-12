@extends('backend.layouts.grid')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Earnings Records') . ' | #' . $record->id)
@section('back', route('admin.earnings.records.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <div class="card-header bg-secondary border-bottom-0 text-white">{{ admin_trans('Record details') }}</div>
        <div class="card-body">
            @if ($record->earning_statistic_id)
                <div class="alert alert-primary">
                    {{ admin_trans('This record relates to earning through referral, and you can view the associated download record to it by') }}
                    <a
                        href="{{ route('admin.earnings.records.show', $record->earning_statistic_id) }}">{{ admin_trans('clicking here') }}</a>
                </div>
            @endif
            <table class="table custom-table table-striped table-bordered mb-0">
                <tbody>
                    <tr>
                        <th>{{ admin_trans('ID') }}</th>
                        <td>#{{ $record->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('User') }}</th>
                        <td>
                            <a href="{{ route('admin.members.users.edit', $record->user->id) }}"><i
                                    class="fa fa-user me-2"></i>{{ $record->user->username }}</a>
                        </td>
                    </tr>
                    @if ($record->referral_id)
                        <tr>
                            <th>{{ admin_trans('Referred User') }}</th>
                            <td>
                                <a href="{{ route('admin.members.users.edit', $record->referral->referred_user->id) }}"><i
                                        class="fa fa-user me-2"></i>{{ $record->referral->referred_user->username }}</a>
                            </td>
                        </tr>
                    @endif
                    @if ($record->ip)
                        <tr>
                            <th>{{ admin_trans('IP Address') }}</th>
                            <td>
                                @if (!demoMode())
                                    <a href="{{ route('admin.members.users.logsbyip', $record->ip) }}"><i
                                            class="fa-solid fa-location-dot me-2"></i>{{ $record->ip }}</a>
                                @else
                                    <span>{{ admin_trans('Hidden in demo') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    @if ($record->country)
                        <tr>
                            <th>{{ admin_trans('Country') }}</th>
                            <td>{{ $record->country }}</td>
                        </tr>
                    @endif
                    @if ($record->payout_rate)
                        <tr>
                            <th>{{ admin_trans('Payout Rate') }}</th>
                            <td>{{ priceSymbol($record->payout_rate) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>{{ admin_trans('Earnings') }}</th>
                        <td><strong
                                class="{{ $record->earnings > 0 ? 'text-success' : 'text-dark' }}">{{ earnings($record->earnings) }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('Source') }}</th>
                        <td>{{ ucfirst($record->earning_source) }}</td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('Status') }}</th>
                        <td>
                            @if ($record->isValid())
                                <span class="badge bg-green">{{ admin_trans('Valid') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Invalid') }}</span>
                            @endif
                        </td>
                    </tr>
                    @if ($record->status_reason)
                        <tr>
                            <th>{{ admin_trans('Status Reason') }}</th>
                            <td>{{ $record->status_reason }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>{{ admin_trans('Date') }}</th>
                        <td>{{ dateFormat($record->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if (!$record->earning_statistic_id)
        <div class="card mt-4">
            <div class="card-header bg-secondary border-bottom-0 text-white">{{ admin_trans('Referer details') }}</div>
            <div class="card-body">
                <table class="table custom-table table-striped table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th>{{ admin_trans('Referer domain') }}</th>
                            <td>{{ $record->referer_domain ?? '--' }}</td>
                        </tr>
                        @if ($record->referer_details)
                            @if ($record->referer_details->referer)
                                <tr>
                                    <th>{{ admin_trans('Referer link') }}</th>
                                    <td><a href="{{ $record->referer_details->referer }}">
                                            {{ $record->referer_details->referer }}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            @if ($record->referer_details->path)
                                <tr>
                                    <th>{{ admin_trans('Referer path') }}</th>
                                    <td>{{ $record->referer_details->path }}</td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header bg-secondary border-bottom-0 text-white">{{ admin_trans('File details') }}</div>
            <div class="card-body">
                <table class="table custom-table table-striped table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th>{{ admin_trans('ID') }}</th>
                            <td>
                                @if ($record->file_entry)
                                    <a
                                        href="{{ route('admin.files.users.show', $record->file_entry->id) }}">#{{ $record->file_entry_details->id }}</a>
                                @else
                                    <span>#{{ $record->file_entry_details->id }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ admin_trans('Name') }}</th>
                            <td>{{ $record->file_entry_details->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ admin_trans('Path') }}</th>
                            <td>{{ !demoMode() ? $record->file_entry_details->path : admin_trans('Hidden in demo') }}
                            </td>
                        </tr>
                        @if ($record->file_entry_details->description)
                            <tr>
                                <th>{{ admin_trans('Description') }}</th>
                                <td>{{ $record->file_entry_details->description }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>{{ admin_trans('Mime type') }}</th>
                            <td>{{ $record->file_entry_details->mime }}</td>
                        </tr>
                        <tr>
                            <th>{{ admin_trans('Extension') }}</th>
                            <td>{{ $record->file_entry_details->extension }}</td>
                        </tr>
                        <tr>
                            <th>{{ admin_trans('Size') }}</th>
                            <td>{{ formatBytes($record->file_entry_details->size) }}</td>
                        </tr>
                        <tr>
                            <th>{{ admin_trans('Uploeded date') }}</th>
                            <td>{{ dateFormat($record->file_entry_details->created_at) }}</td>
                        </tr>
                    </tbody>
                </table>
                @if (!$record->file_entry)
                    <div class="alert alert-danger text-center mt-3 mb-0">
                        {{ admin_trans('This file has been deleted') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
