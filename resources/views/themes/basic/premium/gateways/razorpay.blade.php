@extends('themes.basic.layouts.single')
@section('title', translate('Premium membership', 'premium'))
@section('hide_header', true)
@section('content')
    <div class="section my-5">
        <div class="container">
            <div class="section-inner">
                <div class="section-body">
                    <div class="col-lg-4 m-auto">
                        <div class="card-v">
                            <h5 class="mb-3">{{ translate('Complete the payment', 'premium') }}</h5>
                            <h1 class="mb-3">{{ priceSymbol($trx->price) }}</h1>
                            <form action="{{ route('premium.payment.razorpay') }}" method="POST">
                                @csrf
                                <input type="hidden" name="trx_id" value="{{ hashid($trx->id) }}">
                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                    @foreach ($data->details as $key => $value)
                        data-{{ $key }}="{{ $value }}" @endforeach>
                                </script>
                            </form>
                            <a href="{{ route('user.settings.subscription') }}"
                                class="btn btn-outline-primary btn-md radius radius-md w-100 mt-3">{{ translate('Cancel Payment', 'premium') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            "use strict";
            let razorpayPaymentButton = $('.razorpay-payment-button');
            razorpayPaymentButton.addClass('btn btn-primary btn-md radius radius-md w-100');
        </script>
    @endpush
@endsection
