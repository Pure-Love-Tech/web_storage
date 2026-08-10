@extends('themes.basic.layouts.single')
@section('title', translate('Payment Proof', 'payment proof'))
@section('content')
    <div class="section section-start">
        {{-- <x-ad alias="other_pages_top" @class('ad-728x90 mb-5') /> --}}
        <div class="container">
            <div class="custom-container">
                <div class="section-inner">
                    <div class="section-body">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 justify-content-center g-3 mb-4">
                            <div class="col">
                                <div class="counter counter-gradient">
                                    <div class="card-v">
                                        <div class="counter-info">
                                            <h5 class="counter-title">{{ translate('Total Requests', 'payment proof') }}
                                            </h5>
                                            <p class="counter-number">{{ $counters['total_requests'] }}</p>
                                        </div>
                                        <div class="counter-icon">
                                            <i class="fa-solid fa-money-bill-transfer"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="counter counter-gradient">
                                    <div class="card-v">
                                        <div class="counter-info">
                                            <h5 class="counter-title">{{ translate('Total Paid Amount', 'payment proof') }}
                                            </h5>
                                            <p class="counter-number">{{ earnings($counters['total_paid_amount']) }}</p>
                                        </div>
                                        <div class="counter-icon">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payout-table">
                            <div class="card-v p-0">
                                @if ($withdrawals->count() > 0)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-start">{{ translate('Date', 'payment proof') }}</th>
                                                <th>{{ translate('Username', 'payment proof') }}</th>
                                                <th>{{ translate('Amount', 'payment proof') }}</th>
                                                <th class="text-end">{{ translate('Method', 'payment proof') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-muted">
                                            @foreach ($withdrawals as $withdrawal)
                                                <tr>
                                                    <td class="text-start">{{ dateFormat($withdrawal->created_at) }}</td>
                                                    <td>{{ $withdrawal->user->usernameMasked() }}</td>
                                                    <td class="text-success">
                                                        <strong>{{ earnings($withdrawal->total) }}</strong>
                                                    </td>
                                                    <td class="text-end">{{ $withdrawal->method }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="card-body p-4">
                                        <div class="text-center text-muted">
                                            {{ translate('No payment proofs available', 'payment proof') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{ $withdrawals->links() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- <x-ad alias="other_pages_bottom" @class('ad-728x90 mt-5') /> --}}
    </div>
@endsection
