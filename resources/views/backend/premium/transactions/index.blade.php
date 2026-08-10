@extends('backend.layouts.grid')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Transactions'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-secondary">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Unpaid') }}
                        ({{ number_format($counters['unpaid']['number']) }})</p>
                    <p class="vironeer-counter-card-number">{{ priceSymbol($counters['unpaid']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-orange">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Pending') }}
                        ({{ number_format($counters['pending']['number']) }})</p>
                    <p class="vironeer-counter-card-number">{{ priceSymbol($counters['pending']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Paid') }}
                        ({{ number_format($counters['paid']['number']) }})</p>
                    <p class="vironeer-counter-card-number">{{ priceSymbol($counters['paid']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Cancelled') }}
                        ({{ number_format($counters['cancelled']['number']) }})</p>
                    <p class="vironeer-counter-card-number">{{ priceSymbol($counters['cancelled']['amount']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-12">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ admin_trans('Search...') }}" value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-4">
                        @include('backend.partials.users-select')
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ admin_trans('Status') }}">
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                {{ admin_trans('Unpaid') }}</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                {{ admin_trans('Pending') }}</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>
                                {{ admin_trans('Paid') }}</option>
                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>
                                {{ admin_trans('Cancelled') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="payment_method" class="form-select selectpicker"
                            title="{{ admin_trans('Payment Method') }}" data-live-search="true">
                            @foreach ($paymentGateways as $paymentGateway)
                                <option value="{{ $paymentGateway->id }}"
                                    {{ request('payment_method') == $paymentGateway->id ? 'selected' : '' }}>
                                    {{ $paymentGateway->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.premium.transactions.index') }}"
                            class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            @if ($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th>{{ admin_trans('ID') }}</th>
                                <th>{{ admin_trans('User') }}</th>
                                <th>{{ admin_trans('Interval') }}</th>
                                <th>{{ admin_trans('Price') }}</th>
                                <th>{{ admin_trans('Payment Method') }}</th>
                                <th>{{ admin_trans('Status') }}</th>
                                <th>{{ admin_trans('Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $trx)
                                <tr>
                                    <td><a href="{{ route('admin.premium.transactions.edit', $trx->id) }}"><i
                                                class="fa-solid fa-receipt me-2"></i>#{{ $trx->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $trx->user->id) }}"
                                            class="text-dark"><i class="fa fa-user me-2"></i>{{ $trx->user->name }}
                                            ({{ $trx->user->email }})
                                        </a>
                                    </td>
                                    <td>
                                        {{ $trx->interval }}
                                        @if ($trx->interval == 1)
                                            {{ admin_trans('day') }}
                                        @else
                                            {{ admin_trans('days') }}
                                        @endif
                                    </td>
                                    <td><strong>{{ priceSymbol($trx->price) }}</strong></td>
                                    <td>
                                        <a href="{{ route('admin.premium.payment-gateways.edit', $trx->paymentGateway->id) }}"
                                            class="text-dark"><i
                                                class="fa-regular fa-credit-card me-2"></i>{{ $trx->paymentGateway->name }}</a>
                                    </td>
                                    <td>
                                        @if ($trx->isUnpaid())
                                            <span class="badge bg-secondary">{{ admin_trans('Unpaid') }}</span>
                                        @elseif($trx->isPending())
                                            <span class="badge bg-orange">{{ admin_trans('Pending') }}</span>
                                        @elseif($trx->isPaid())
                                            <span class="badge bg-green">{{ admin_trans('Paid') }}</span>
                                        @elseif($trx->isCancelled())
                                            <span class="badge bg-red">{{ admin_trans('Cancelled') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ dateFormat($trx->created_at) }}</td>
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
                                                        href="{{ route('admin.premium.transactions.edit', $trx->id) }}"><i
                                                            class="fa-regular fa-pen-to-square me-2"></i>{{ admin_trans('Edit') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.premium.transactions.destroy', $trx->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="vironeer-able-to-delete dropdown-item text-danger"><i
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
    {{ $transactions->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
