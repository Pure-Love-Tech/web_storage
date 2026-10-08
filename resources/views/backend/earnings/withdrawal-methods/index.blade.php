@extends('backend.layouts.form')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Withdrawal Methods'))
@section('container', 'container-max-lg')
@section('link', route('admin.earnings.withdrawal-methods.create'))
@if ($withdrawalMethods->count() == 0)
    @section('btn_action', 'disabled')
@endif
@section('content')
    @if ($withdrawalMethods->count() > 0)
        <form id="vironeer-submited-form" action="{{ route('admin.earnings.withdrawal-methods.sort') }}" method="POST">
            @csrf
            <input name="ids" id="ids" value="{{ $idsArray }}" hidden>
        </form>
        <div class="card mb-3">
            <ul class="vironeer-sort-menu custom-list-group list-group list-group-flush">
                @foreach ($withdrawalMethods as $withdrawalMethod)
                    <li data-id="{{ $withdrawalMethod->id }}"
                        class="list-group-item d-flex justify-content-between align-items-center">
                        <h5 class="m-0">
                            <span class="vironeer-navigation-handle me-2 text-muted"><i
                                    class="fas fa-arrows-alt"></i></span>
                            <span>{{ $withdrawalMethod->name }}</span>
                            <small class="text-muted">({{ priceSymbol($withdrawalMethod->minimum) }})</small>
                        </h5>
                        <div class="buttons">
                            @if ($withdrawalMethod->status)
                                <span class="badge bg-success me-4">{{ admin_trans('Active') }}</span>
                            @else
                                <span class="badge bg-danger me-4">{{ admin_trans('Disabled') }}</span>
                            @endif
                            <a class="btn btn-blue btn-sm me-2"
                                href="{{ route('admin.earnings.withdrawal-methods.edit', $withdrawalMethod->id) }}"><i
                                    class="fa fa-edit"></i></a>
                            <form class="d-inline"
                                action="{{ route('admin.earnings.withdrawal-methods.destroy', $withdrawalMethod->id) }}"
                                method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="vironeer-able-to-delete btn btn-danger btn-sm"><i
                                        class="far fa-trash-alt"></i></button>
                            </form>
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
    @if ($withdrawalMethods->count() > 0)
        @push('styles_libs')
            <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
        @endpush
    @endif
@endsection
