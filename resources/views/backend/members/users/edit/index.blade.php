@extends('backend.layouts.form')
@section('section', admin_trans('Users'))
@section('title', $user->name . ' | ' . admin_trans('Details'))
@section('back', route('admin.members.users.index'))
@section('content')
    <div class="row row-cols-1 row-cols-lg-3 row-cols-xxl-3 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Account Balance') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($user->balance()) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c9">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Downloads Earnings') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($user->downloads_earnings) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c8">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Referrals Earnings') }}</p>
                    <p class="vironeer-counter-card-number">{{ earnings($user->referrals_earnings) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            @include('backend.members.users.includes.list')
        </div>
        <div class="col-lg-9">
            <form id="vironeer-submited-form" action="{{ route('admin.members.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card mb-3">
                    <div class="card-header">{{ admin_trans('Actions') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ admin_trans('Account status') }} </label>
                                <input type="checkbox" name="status" data-toggle="toggle"
                                    data-on="{{ admin_trans('Active') }}" data-off="{{ admin_trans('Banned') }}"
                                    {{ $user->status ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ admin_trans('Email status') }} </label>
                                <input type="checkbox" name="email_status" data-toggle="toggle"
                                    data-on="{{ admin_trans('Verified') }}" data-off="{{ admin_trans('Unverified') }}"
                                    {{ !is_null($user->email_verified_at) ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ admin_trans('Two-Factor Authentication') }} </label>
                                <input id="2faCheckbox" type="checkbox" name="google2fa_status" data-toggle="toggle"
                                    data-on="{{ admin_trans('Active') }}" data-off="{{ admin_trans('Disabled') }}"
                                    {{ $user->google2fa_status ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">{{ admin_trans('Account Balance') }}</div>
                    <div class="card-body">
                        <div class="row g-3 mb-2">
                            <div class="col-lg-6">
                                <label class="form-label">{{ admin_trans('Downloads Earnings') }} </label>
                                <div class="custom-input-group input-group">
                                    <input type="number" name="downloads_earnings" class="form-control form-control-lg"
                                        value="{{ $user->downloads_earnings }}" step="any">
                                    <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ admin_trans('Referrals Earnings') }} </label>
                                <div class="custom-input-group input-group">
                                    <input type="number" name="referrals_earnings" class="form-control form-control-lg"
                                        value="{{ $user->referrals_earnings }}" step="any">
                                    <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">{{ admin_trans('Account details') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Firstname') }} </label>
                                    <input type="firstname" name="firstname" class="form-control form-control-lg"
                                        value="{{ $user->firstname }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Lastname') }} </label>
                                    <input type="lastname" name="lastname" class="form-control form-control-lg"
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Username') }}</label>
                            <input type="username" name="username" class="form-control form-control-lg"
                                value="{{ $user->username }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('E-mail Address') }}</label>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control form-control-lg"
                                    value="{{ $user->email }}" required>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sendMailModal"><i
                                        class="far fa-paper-plane me-2"></i>{{ admin_trans('Send Email') }}</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Phone number') }} </label>
                            <input type="tel" name="mobile" class="form-control form-control-lg"
                                value="{{ $user->mobile }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Address line 1') }}</label>
                            <input type="text" name="address_1" class="form-control form-control-lg"
                                value="{{ @$user->address->address_1 }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Address line 2') }}</label>
                            <input type="text" name="address_2" class="form-control form-control-lg"
                                placeholder="{{ admin_trans('Address line 2') }}"
                                value="{{ @$user->address->address_2 }}">
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('City') }}</label>
                                    <input type="text" name="city" class="form-control form-control-lg"
                                        value="{{ @$user->address->city }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('State') }}</label>
                                    <input type="text" name="state" class="form-control form-control-lg"
                                        value="{{ @$user->address->state }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Postal code') }}</label>
                                    <input type="text" name="zip" class="form-control form-control-lg"
                                        value="{{ @$user->address->zip }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ admin_trans('Country') }}</label>
                            <select name="country" class="form-select form-control-lg">
                                <option value="">--</option>
                                @foreach (countries() as $country)
                                    <option value="{{ $country->id }}" @if ($country->name == @$user->address->country) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">{{ admin_trans('Withdrawal details') }}</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Withdrawal Method') }} </label>
                            <select name="withdrawal_method" class="form-select form-select-lg">
                                <option value="">--</option>
                                @foreach ($withdrawalMethods as $withdrawalMethod)
                                    <option value="{{ $withdrawalMethod->id }}"
                                        {{ $withdrawalMethod->id == $user->withdrawal_method_id ? 'selected' : '' }}>
                                        {{ $withdrawalMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ admin_trans('Withdrawal Account') }} </label>
                            <textarea type="text" name="withdrawal_account" class="form-control" rows="4">{{ $user->withdrawal_account }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMailModalLabel">
                        {{ admin_trans('Send Mail to ') }}{{ $user->email }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.members.users.sendmail', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Subject') }}</label>
                                    <input type="subject" name="subject" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Reply to') }}</label>
                                    <input type="email" name="reply_to" class="form-control form-control-lg"
                                        value="{{ auth()->guard('admin')->user()->email }}" required>
                                </div>
                            </div>
                        </div>
                        <textarea name="message" rows="10" class="ckeditor"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-lg">{{ admin_trans('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
    @endpush
@endsection
