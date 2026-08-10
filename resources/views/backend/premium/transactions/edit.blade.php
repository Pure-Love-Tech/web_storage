@extends('backend.layouts.grid')
@section('title', admin_trans('Transactions') . ' | #' . $trx->id)
@section('back', route('admin.premium.transactions.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <div class="card-header bg-secondary text-white border-bottom-0">
            {{ admin_trans('Transaction Details') }}
        </div>
        <div class="card-body">
            <table class="table custom-table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th>{{ admin_trans('ID') }}</th>
                        <td>#{{ $trx->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('User') }}</th>
                        <td>
                            <a href="{{ route('admin.members.users.edit', $trx->user->id) }}"><i
                                    class="fa fa-user me-2"></i>{{ $trx->user->name }}</a>
                            ({{ $trx->user->email }})
                        </td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('Interval') }}</th>
                        <td>
                            {{ $trx->interval }}
                            @if ($trx->interval == 1)
                                {{ admin_trans('day') }}
                            @else
                                {{ admin_trans('days') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('Price') }}</th>
                        <td><strong>{{ priceSymbol($trx->price) }}</strong></td>
                    </tr>
                    <tr>
                        <th>{{ admin_trans('Payment Method') }}</th>
                        <td>
                            <a href="{{ route('admin.premium.payment-gateways.edit', $trx->paymentGateway->id) }}"
                                class="text-dark"><i
                                    class="fa-regular fa-credit-card me-2"></i>{{ $trx->paymentGateway->name }}</a>
                        </td>
                    </tr>
                    @if ($trx->payment_id)
                        <tr>
                            <th>{{ admin_trans('Payment ID') }}</th>
                            <td>{{ $trx->payment_id }}</td>
                        </tr>
                    @endif
                    @if ($trx->payer_id)
                        <tr>
                            <th>{{ admin_trans('Payer ID') }}</th>
                            <td>{{ $trx->payer_id }}</td>
                        </tr>
                    @endif
                    @if ($trx->payer_email)
                        <tr>
                            <th>{{ admin_trans('Payer Email') }}</th>
                            <td>{{ $trx->payer_email }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>{{ admin_trans('Status') }}</th>
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
                    </tr>
                    @if ($trx->proof)
                        <tr>
                            <th>{{ admin_trans('Payment Proof') }}</th>
                            <td><a href="{{ route('admin.premium.transactions.show', $trx->id) }}" target="_blank"><i
                                        class="fa-solid fa-file-lines me-2"></i>{{ str($trx->proof)->replace('uploads/transactions/', '') }}</a>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>{{ admin_trans('Date') }}</th>
                        <td>{{ dateFormat($trx->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
            @if ($trx->isPending())
                <div class="mt-3">
                    <form action="{{ route('admin.premium.transactions.update', $trx->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-12 col-lg">
                                <button class="btn btn-green btn-lg w-100 action-confirm" name="status"
                                    value="2">{{ admin_trans('Mark as Paid') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button class="btn btn-red btn-lg w-100 action-confirm" name="status"
                                    value="3">{{ admin_trans('Mark as Cancelled') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
