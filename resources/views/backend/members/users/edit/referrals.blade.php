@extends('backend.layouts.grid')
@section('title', $user->name . ' | ' . admin_trans('Referrals'))
@section('back', route('admin.members.users.index'))
@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('backend.members.users.includes.list')
        </div>
        <div class="col-lg-9">
            <div class="card">
                <table id="datatable" class="table w-100">
                    <thead>
                        <tr>
                            <th class="tb-w-3x">#</th>
                            <th class="tb-w-7x">{{ admin_trans('User') }}</th>
                            <th class="tb-w-3x">{{ admin_trans('Earnings') }}</th>
                            <th class="tb-w-7x">{{ admin_trans('Date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($referrals as $referral)
                            <tr>
                                <td>{{ $referral->id }}</td>
                                <td>
                                    <a href="{{ route('admin.members.users.edit', $referral->referred_user->id) }}">
                                        <i class="fa fa-user me-2"></i>
                                        {{ $referral->referred_user->username }}
                                    </a>
                                </td>
                                <td>{{ earnings($referral->earnings) }}</td>
                                <td>{{ dateFormat($referral->created_at) }}</td>
                                <td>
                                    <form
                                        action="{{ route('admin.members.users.referrals.destroy', [$user->id, $referral->id]) }}"
                                        method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger vironeer-able-to-delete btn-sm"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
