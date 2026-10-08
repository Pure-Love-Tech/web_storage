@extends('backend.layouts.grid')
@section('title', admin_trans('Withdrawals') . ' | #' . $withdrawal->id)
@section('back', route('admin.withdrawals.index'))
@if ($withdrawal->isCancelled() || $withdrawal->isReturned())
    @section('container', 'container-max-lg')
@endif
@section('content')
    <div class="row g-3">
        <div class="{{ !$withdrawal->isCancelled() && !$withdrawal->isReturned() ? 'col-lg-8' : 'col-lg-12' }}">
            <div class="card">
                <div class="card-header bg-secondary text-white border-bottom-0">
                    {{ admin_trans('Withdrawal Details') }}
                </div>
                <div class="card-body">
                    <table class="table custom-table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th>{{ admin_trans('ID') }}</th>
                                <td>#{{ $withdrawal->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('User') }}</th>
                                <td>
                                    <a href="{{ route('admin.members.users.edit', $withdrawal->user->id) }}"><i
                                            class="fa fa-user me-2"></i>{{ $withdrawal->user->name }}</a>
                                    ({{ $withdrawal->user->username }})
                                </td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Downloads Earnings') }}</th>
                                <td><strong>{{ earnings($withdrawal->downloads_earnings) }}</strong></td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Referrals Earnings') }}</th>
                                <td><strong>{{ earnings($withdrawal->referrals_earnings) }}</strong></td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Total Amount') }}</th>
                                <td class="text-success"><strong>{{ earnings($withdrawal->total) }}</strong></td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Withdrawal Method') }}</th>
                                <td>{{ $withdrawal->method }}</td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Withdrawal account') }}</th>
                                <td>{{ $withdrawal->account }}</td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Status') }}</th>
                                <td>
                                    @if ($withdrawal->isPending())
                                        <div class="badge rounded-pill bg-orange">
                                            {{ admin_trans('Pending') }}
                                        </div>
                                    @elseif ($withdrawal->isReturned())
                                        <div class="badge rounded-pill bg-purple">
                                            {{ admin_trans('Returned') }}
                                        </div>
                                    @elseif($withdrawal->isApproved())
                                        <div class="badge rounded-pill bg-blue">
                                            {{ admin_trans('Approved') }}
                                        </div>
                                    @elseif($withdrawal->isCompleted())
                                        <div class="badge rounded-pill bg-green">
                                            {{ admin_trans('Completed') }}
                                        </div>
                                    @elseif($withdrawal->isCancelled())
                                        <div class="badge rounded-pill bg-red">
                                            {{ admin_trans('Cancelled') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ admin_trans('Withdrawal Date') }}</th>
                                <td>{{ dateFormat($withdrawal->created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if (!$withdrawal->isCancelled() && !$withdrawal->isReturned())
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white border-bottom-0">
                        {{ admin_trans('Take Action') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">{{ admin_trans('Status') }}</label>
                                    <select name="status" class="form-select" title="{{ admin_trans('Status') }}">
                                        <option value="1" {{ $withdrawal->isPending() ? 'selected' : '' }}>
                                            {{ admin_trans('Pending') }}</option>
                                        <option value="2" {{ $withdrawal->isReturned() ? 'selected' : '' }}>
                                            {{ admin_trans('Returned') }}</option>
                                        <option value="3" {{ $withdrawal->isApproved() ? 'selected' : '' }}>
                                            {{ admin_trans('Approved') }}</option>
                                        <option value="4" {{ $withdrawal->isCompleted() ? 'selected' : '' }}>
                                            {{ admin_trans('Completed') }}</option>
                                        <option value="5" {{ $withdrawal->isCancelled() ? 'selected' : '' }}>
                                            {{ admin_trans('Cancelled') }}</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ admin_trans('Notify the user via email') }} </label>
                                    <input type="checkbox" name="user_notify" data-toggle="toggle"
                                        data-on="{{ admin_trans('Yes') }}" data-off="{{ admin_trans('No') }}">
                                </div>
                                <div class="col-12">
                                    <button
                                        class="btn btn-primary vironeer-form-confirm w-100">{{ admin_trans('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
