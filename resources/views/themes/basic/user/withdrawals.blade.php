@extends('themes.basic.user.layouts.app')
@section('title', translate('Withdrawals', 'withdrawals'))
@section('content')
    <div class="row row-cols-1 row-cols-xl-2 row-cols-xxl-3 g-3 mb-4">
        <div class="col">
            <div class="counter counter-green">
                <div class="card-v">
                    <div class="counter-info">
                        <h5 class="counter-title">{{ translate('Available Balance', 'withdrawals') }}</h5>
                        <p class="counter-number">{{ earnings(auth()->user()->balance()) }}</p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.67188 14.3298C8.67188 15.6198 9.66188 16.6598 10.8919 16.6598H13.4019C14.4719 16.6598 15.3419 15.7498 15.3419 14.6298C15.3419 13.4098 14.8119 12.9798 14.0219 12.6998L9.99187 11.2998C9.20187 11.0198 8.67188 10.5898 8.67188 9.36984C8.67188 8.24984 9.54187 7.33984 10.6119 7.33984H13.1219C14.3519 7.33984 15.3419 8.37984 15.3419 9.66984"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 6V18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-yellow">
                <div class="card-v">
                    <div class="counter-info">
                        <h5 class="counter-title">{{ translate('Pending Withdrawal Amount', 'withdrawals') }}</h5>
                        <p class="counter-number">
                            {{ earnings($counters['pending_withdrawals']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 14.5C13.3807 14.5 14.5 13.3807 14.5 12C14.5 10.6193 13.3807 9.5 12 9.5C10.6193 9.5 9.5 10.6193 9.5 12C9.5 13.3807 10.6193 14.5 12 14.5Z"
                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.5 9.5V14.5" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M5 22C7.20914 22 9 20.2091 9 18C9 15.7909 7.20914 14 5 14C2.79086 14 1 15.7909 1 18C1 20.2091 2.79086 22 5 22Z"
                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.25 16.75V17.68C5.25 18.03 5.07001 18.36 4.76001 18.54L4 19" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 15.2V9C2 5.5 4 4 7 4H17C20 4 22 5.5 22 9V15C22 18.5 20 20 17 20H8.5"
                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-primary">
                <div class="card-v">
                    <div class="counter-info">
                        <h5 class="counter-title">{{ translate('Total Withdrawn Amount', 'withdrawals') }}</h5>
                        <p class="counter-number">
                            {{ earnings($counters['total_withdrawals']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.5 13.7502C9.5 14.7202 10.25 15.5002 11.17 15.5002H13.05C13.85 15.5002 14.5 14.8202 14.5 13.9702C14.5 13.0602 14.1 12.7302 13.51 12.5202L10.5 11.4702C9.91 11.2602 9.51001 10.9402 9.51001 10.0202C9.51001 9.18023 10.16 8.49023 10.96 8.49023H12.84C13.76 8.49023 14.51 9.27023 14.51 10.2402"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 7.5V16.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 6V2H18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 7L22 2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (translate('withdrawals description', 'withdrawals'))
        <div class="card-v mb-4">
            {!! replace_br(translate('withdrawals description', 'withdrawals')) !!}
        </div>
    @endif
    <div class="card-v mb-4">
        @if (auth()->user()->hasWithdrawalAccount())
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-auto justify-content-between align-items-xl-center g-4">
                <div class="col">
                    <div class="withdraw-title">
                        <h6 class="mb-0">{{ translate('Request a Withdrawal', 'withdrawals') }}</h6>
                    </div>
                </div>
                <div class="col">
                    <div class="text-xl-center">
                        <h6 class="mb-2">{{ translate('Method', 'withdrawals') }}</h6>
                        <p class="text-primary mb-0">{{ auth()->user()->withdrawal_method->name }}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="text-xl-center">
                        <h6 class="mb-2">{{ translate('Account', 'withdrawals') }}</h6>
                        <p class="text-primary mb-0">{{ shortertext(auth()->user()->withdrawal_account, 30) }}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="text-xl-center">
                        <h6 class="mb-2">{{ translate('Minimum', 'withdrawals') }}</h6>
                        <p class="text-primary mb-0">{{ priceSymbol(auth()->user()->withdrawal_method->minimum) }}</p>
                    </div>
                </div>
                <div class="col-xl-4">
                    <button class="btn btn-secondary btn-md radius radius-md w-100"
                        {{ auth()->user()->balance() >= auth()->user()->withdrawal_method->minimum? 'data-bs-toggle=modal data-bs-target=#WithdrawModal': 'disabled' }}>
                        <i class="fa-regular fa-paper-plane me-1"></i>
                        {{ translate('Withdraw', 'withdrawals') }}
                    </button>
                </div>
            </div>
        @else
            <div class="alert alert-primary mb-0">
                <p class="mb-0"><i class="fa-regular fa-circle-question me-2"></i>
                    {{ translate('Missing withdrawal details alert', 'withdrawals') }}
                    <a
                        href="{{ route('user.settings.withdrawal') }}">{{ translate('withdrawal settings', 'withdrawals') }}</a>
                </p>
            </div>
        @endif
    </div>
    <div class="ref-table">
        <div class="card-v">
            @if ($withdrawals->count() > 0)
                <h5 class="mb-3">{{ translate('Withdrawals', 'withdrawals') }}</h5>
                <div class="dash-table">
                    <table class="table text-center table-borderless">
                        <thead>
                            <tr>
                                <th>{{ translate('ID', 'withdrawals') }}</th>
                                <th>{{ translate('Downloads Earnings', 'withdrawals') }}</th>
                                <th>{{ translate('Referrals Earnings', 'withdrawals') }}</th>
                                <th>{{ translate('Total', 'withdrawals') }}</th>
                                <th>{{ translate('Method', 'withdrawals') }}</th>
                                <th>{{ translate('Account', 'withdrawals') }}</th>
                                <th>{{ translate('Status', 'withdrawals') }}</th>
                                <th>{{ translate('Date', 'withdrawals') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-muted">
                            @foreach ($withdrawals as $withdrawal)
                                <tr>
                                    <td>#{{ $withdrawal->id }}</td>
                                    <td>{{ earnings($withdrawal->downloads_earnings) }}</td>
                                    <td>{{ earnings($withdrawal->referrals_earnings) }}</td>
                                    <td>{{ earnings($withdrawal->total) }}</td>
                                    <td>{{ $withdrawal->method }}</td>
                                    <td>{{ shortertext($withdrawal->account, 20) }}</td>
                                    <td>
                                        @if ($withdrawal->isPending())
                                            <div class="badge rounded-pill bg-orange">
                                                {{ translate('Pending', 'withdrawals') }}
                                            </div>
                                        @elseif($withdrawal->isReturned())
                                            <div class="badge rounded-pill bg-purple">
                                                {{ translate('Returned', 'withdrawals') }}
                                            </div>
                                        @elseif($withdrawal->isApproved())
                                            <div class="badge rounded-pill bg-blue">
                                                {{ translate('Approved', 'withdrawals') }}
                                            </div>
                                        @elseif($withdrawal->isCompleted())
                                            <div class="badge rounded-pill bg-green">
                                                {{ translate('Completed', 'withdrawals') }}
                                            </div>
                                        @elseif($withdrawal->isCancelled())
                                            <div class="badge rounded-pill bg-red">
                                                {{ translate('Cancelled', 'withdrawals') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ dateFormat($withdrawal->created_at) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $withdrawals->links() }}
            @else
                <div class="py-5 text-center">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150"
                            viewBox="0 0 647.63626 632.17383" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path
                                d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z"
                                transform="translate(-276.18187 -133.91309)" fill="#f2f2f2" />
                            <path
                                d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z"
                                transform="translate(-276.18187 -133.91309)" fill="#3f3d56" />
                            <path
                                d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z"
                                transform="translate(-276.18187 -133.91309)"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <circle cx="190.15351" cy="24.95465" r="20"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff" />
                            <path
                                d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z"
                                transform="translate(-276.18187 -133.91309)" fill="#e6e6e6" />
                            <path
                                d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z"
                                transform="translate(-276.18187 -133.91309)" fill="#3f3d56" />
                            <path
                                d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z"
                                transform="translate(-276.18187 -133.91309)"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <circle cx="433.63626" cy="105.17383" r="20"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff" />
                        </svg>
                    </div>
                    <h4>{{ translate('You don\'t have any Withdrawal requests', 'withdrawals') }}</h4>
                    <p class="mb-0">
                        {{ translate('When you have withdrawal requests, you will be able to see them here.', 'withdrawals') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
    @if (auth()->user()->hasWithdrawalAccount() &&
            auth()->user()->balance() >= auth()->user()->withdrawal_method->minimum)
        <div class="modal custom-modal fade" id="WithdrawModal" tabindex="-1" aria-labelledby="WithdrawModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="WithdrawModalLabel">
                            {{ translate('Withdrawal Confirmation', 'withdrawals') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user.withdrawals.withdraw') }}" method="POST">
                            @csrf
                            <p class="mb-4">
                                @php
                                    $obj = ['{withdrawal_amount}', '{withdrawal_account}', '{withdrawal_method}'];
                                    $rp = [
                                        earnings(
                                            auth()
                                                ->user()
                                                ->balance(),
                                        ),
                                        auth()->user()->withdrawal_account,
                                        auth()->user()->withdrawal_method->name,
                                    ];
                                @endphp
                                {{ str_replace($obj, $rp, translate('Are you sure you want to withdraw {withdrawal_amount} to {withdrawal_account} via {withdrawal_method}?', 'withdrawals')) }}
                            </p>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-secondary btn-md radius radius-md w-100"
                                        data-bs-dismiss="modal">{{ translate('Cancel', 'withdrawals') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button
                                        class="btn btn-primary btn-md radius radius-md w-100">{{ translate('Confirm', 'withdrawals') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
