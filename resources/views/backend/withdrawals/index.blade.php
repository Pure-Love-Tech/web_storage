@extends('backend.layouts.grid')
@section('title', admin_trans('Withdrawals'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-orange">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Pending') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-purple">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Returned') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['returned'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-blue">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-check-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Approved') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['approved'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Completed') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['completed'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Cancelled') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['cancelled'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-c-5">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Pending withdrawal amount') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($counters['pending_withdrawal_amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl">
            <div class="vironeer-counter-card bg-c-4">
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
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ admin_trans('Search...') }}" value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        @include('backend.partials.users-select')
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ admin_trans('Status') }}">
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>
                                {{ admin_trans('Pending') }}</option>
                            <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>
                                {{ admin_trans('Returned') }}</option>
                            <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>
                                {{ admin_trans('Approved') }}</option>
                            <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>
                                {{ admin_trans('Completed') }}</option>
                            <option value="5" {{ request('status') == 5 ? 'selected' : '' }}>
                                {{ admin_trans('Cancelled') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="withdrawal_method" class="form-select selectpicker"
                            title="{{ admin_trans('Withdrawal Method') }}" data-live-search="true">
                            @foreach ($withdrawalMethods as $withdrawalMethod)
                                <option value="{{ $withdrawalMethod->name }}"
                                    {{ request('withdrawal_method') == $withdrawalMethod->name ? 'selected' : '' }}>
                                    {{ $withdrawalMethod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.withdrawals.index') }}"
                            class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            @if ($withdrawals->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th>{{ admin_trans('ID') }}</th>
                                <th>{{ admin_trans('User') }}</th>
                                <th>{{ admin_trans('Downloads Earnings') }}</th>
                                <th>{{ admin_trans('Referrals Earnings') }}</th>
                                <th>{{ admin_trans('Total Amount') }}</th>
                                <th>{{ admin_trans('Method') }}</th>
                                <th class="text-center">{{ admin_trans('Status') }}</th>
                                <th class="text-center">{{ admin_trans('Withdrawal Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $withdrawal)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.withdrawals.edit', $withdrawal->id) }}"><i
                                                class="fa-solid fa-money-check-dollar me-1"></i>#{{ $withdrawal->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $withdrawal->user->id) }}"
                                            class="text-dark"><i
                                                class="fa fa-user me-2"></i>{{ $withdrawal->user->username }}</a>
                                    </td>
                                    <td><strong>{{ earnings($withdrawal->downloads_earnings) }}</strong></td>
                                    <td><strong>{{ earnings($withdrawal->referrals_earnings) }}</strong></td>
                                    <td class="text-success"><strong>{{ earnings($withdrawal->total) }}</strong>
                                    </td>
                                    <td>{{ $withdrawal->method }}</td>
                                    <td class="text-center">
                                        @if ($withdrawal->isPending())
                                            <div class="badge rounded-pill bg-orange">
                                                {{ admin_trans('Pending') }}
                                            </div>
                                        @elseif ($withdrawal->isReturned())
                                            <div class="badge rounded-pill bg-purple">
                                                {{ admin_trans('Returned') }}
                                            </div>
                                        @elseif($withdrawal->isApproved())
                                            <div class="badge rounded-pill bg-blue">
                                                {{ admin_trans('Approved') }}
                                            </div>
                                        @elseif($withdrawal->isCompleted())
                                            <div class="badge rounded-pill bg-green">
                                                {{ admin_trans('Completed') }}
                                            </div>
                                        @elseif($withdrawal->isCancelled())
                                            <div class="badge rounded-pill bg-red">
                                                {{ admin_trans('Cancelled') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ dateFormat($withdrawal->created_at) }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.withdrawals.edit', $withdrawal->id) }}"><i
                                                            class="fa-regular fa-pen-to-square me-2"></i>{{ admin_trans('Edit') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.withdrawals.destroy', $withdrawal->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                                class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete') }}</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @include('backend.partials.empty', ['class' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $withdrawals->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
