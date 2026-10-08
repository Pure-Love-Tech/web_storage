@extends('themes.basic.user.layouts.app')
@section('title', translate('Settings', 'settings'))
@section('content')
    @include('themes.basic.user.settings.includes.links')
    <div class="row g-3 mb-4">
        <div class="{{ $withdrawalMethods->count() > 0 ? 'col-lg-6' : 'col-12' }}">
            <div class="card-v">
                <h5 class="mb-0">{{ translate('Withdrawal Details', 'settings') }}</h5>
                <div class="form-section">
                    <form id="deatilsForm" action="{{ route('user.settings.withdrawal.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Withdrawal Method', 'settings') }} : </label>
                            <select id="withdrawalMethodSelect" name="withdrawal_method"
                                class="form-select form-select-md radius radius-md">
                                <option value="">--</option>
                                @foreach ($withdrawalMethods as $withdrawalMethod)
                                    <option value="{{ $withdrawalMethod->id }}"
                                        {{ $withdrawalMethod->id == $user->withdrawal_method_id ? 'selected' : '' }}>
                                        {{ $withdrawalMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach ($withdrawalMethods as $withdrawalMethod)
                            @if ($withdrawalMethod->description)
                                <div
                                    class="withdrawal-descriptions description-{{ $withdrawalMethod->id }} 
                                    {{ $user->withdrawal_method_id != $withdrawalMethod->id ? 'd-none' : '' }} mb-4">
                                    {!! $withdrawalMethod->description !!}
                                </div>
                            @endif
                        @endforeach
                        <div class="mb-4">
                            <label class="form-label">{{ translate('Withdrawal Account', 'settings') }} : </label>
                            <textarea type="text" name="withdrawal_account" class="form-control radius radius-md" rows="4">{{ $user->withdrawal_account }}</textarea>
                        </div>
                        <button
                            class="btn btn-primary btn-md radius radius-md">{{ translate('Save Changes', 'settings') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @if ($withdrawalMethods->count() > 0)
            <div class="col-lg-6">
                <div class="card-v">
                    <h5 class="mb-0">{{ translate('Withdrawal Methods', 'settings') }}</h5>
                    <div class="form-section">
                        <div class="dash-table2">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ translate('Withdrawal Method', 'settings') }}</th>
                                        <th>{{ translate('Minimum Amount', 'settings') }}</th>
                                    </tr>
                                    @foreach ($withdrawalMethods as $withdrawalMethod)
                                        <tr>
                                            <td>{{ $withdrawalMethod->name }}</td>
                                            <td>{{ priceSymbol($withdrawalMethod->minimum) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
