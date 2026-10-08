@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Payment Gateways'))
@section('container', 'container-max-lg')
@if ($paymentGateways->count() == 0)
    @section('btn_action', 'disabled')
@endif
@section('content')
    @if ($paymentGateways->count() > 0)
        <form id="vironeer-submited-form" action="{{ route('admin.premium.payment-gateways.sort') }}" method="POST">
            @csrf
            <input name="ids" id="ids" value="{{ $idsArray }}" hidden>
        </form>
        <div class="card mb-3">
            <ul class="vironeer-sort-menu custom-list-group list-group list-group-flush">
                @foreach ($paymentGateways as $paymentGateway)
                    <li data-id="{{ $paymentGateway->id }}"
                        class="list-group-item d-flex justify-content-between align-items-center">
                        <h5 class="m-0">
                            <span class="vironeer-navigation-handle me-2 text-muted"><i
                                    class="fas fa-arrows-alt"></i></span>
                            <span>
                                <a href="{{ route('admin.premium.payment-gateways.edit', $paymentGateway->id) }}"
                                    class="text-dark">{{ $paymentGateway->name }}</a>
                            </span>
                        </h5>
                        <div class="buttons">
                            @if ($paymentGateway->status)
                                <span class="badge bg-success me-4">{{ admin_trans('Active') }}</span>
                            @else
                                <span class="badge bg-danger me-4">{{ admin_trans('Disabled') }}</span>
                            @endif
                            <a class="btn btn-blue btn-sm me-2"
                                href="{{ route('admin.premium.payment-gateways.edit', $paymentGateway->id) }}"><i
                                    class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                @include('backend.partials.empty', ['class' => 'empty-lg'])
            </div>
        </div>
    @endif
    @if ($paymentGateways->count() > 0)
        @push('styles_libs')
            <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
        @endpush
    @endif
@endsection
