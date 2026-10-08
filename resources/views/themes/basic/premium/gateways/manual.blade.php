@extends('themes.basic.layouts.single')
@section('title', translate('Premium membership', 'premium'))
@section('hide_header', true)
@section('content')
    <div class="section">
        <div class="container">
            <div class="section-inner">
                <div class="section-body">
                    <div class="col-lg-6 m-auto">
                        <div class="card-v mb-4">
                            <h5 class="mb-3">{{ translate('Transaction price', 'premium') }}</h5>
                            <h1 class="mb-0">{{ priceSymbol($trx->price) }}</h1>
                        </div>
                        <div class="card-v mb-4 p-last">
                            <h5 class="mb-3">
                                {{ str_replace('{payment_gateway_name}', $trx->paymentGateway->name, translate('{payment_gateway_name} instructions', 'premium')) }}
                            </h5>
                            {!! $trx->paymentGateway->instructions !!}
                        </div>
                        <div class="card-v">
                            <h5 class="mb-3">{{ translate('Payment proof', 'premium') }}</h5>
                            <form action="{{ route('premium.payment.manual', $trx->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <p>{{ translate('Payment proof description', 'premium') }}</p>
                                <div class="mb-3">
                                    <input type="file" name="payment_proof"
                                        class="form-control form-control-md radius radius-md"
                                        accept=".jpg, .jpeg, .png, .pdf" required>
                                </div>
                                <div class="row g-3">
                                    <div class="col">
                                        <button
                                            class="btn btn-primary btn-md radius radius-md w-100 action-confirm">{{ translate('Send', 'premium') }}</button>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('user.settings.subscription') }}"
                                            class="btn btn-outline-primary btn-md radius radius-md w-100">{{ translate('Cancel', 'premium') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
