@extends('backend.layouts.grid')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Payout Rates'))
@section('container', 'container-max-lg')
@section('link', route('admin.earnings.payout-rates.create'))
@section('content')
    <div class="card">
        <table class="table w-100 unsort-datatable">
            <thead>
                <tr>
                    <th class="tb-w-3x">{{ admin_trans('#') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Country') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Rate') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('Created date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payoutRates as $payoutRate)
                    <tr>
                        <td>{{ $payoutRate->id }}</td>
                        <td>
                            <a href="{{ route('admin.earnings.payout-rates.edit', $payoutRate->id) }}">
                                <img src="{{ asset($payoutRate->flag) }}"
                                    alt="{{ $payoutRate->country->name ?? admin_trans('All Other Countries') }}"
                                    width="40px" height="40px" class="me-1">
                                <span
                                    class="text-dark">{{ $payoutRate->country->name ?? admin_trans('All Other Countries') }}</span>
                            </a>
                        </td>
                        <td><strong>{{ priceSymbol($payoutRate->amount) }}</strong></td>
                        <td>{{ dateFormat($payoutRate->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.earnings.payout-rates.edit', $payoutRate->id) }}"><i
                                                class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.earnings.payout-rates.destroy', $payoutRate->id) }}"
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
@endsection
