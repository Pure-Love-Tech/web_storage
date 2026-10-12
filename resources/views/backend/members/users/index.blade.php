@extends('backend.layouts.grid')
@section('title', admin_trans('Users'))
@section('link', route('admin.members.users.create'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 {{ licenseType(2) ? 'row-cols-xxl-4' : 'row-cols-xxl-2' }} g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Active') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['active']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Banned') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['banned']) }}</p>
                </div>
            </div>
        </div>
        @if (licenseType(2))
            <div class="col">
                <div class="vironeer-counter-card bg-purple">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Subscribed') }}</p>
                        <p class="vironeer-counter-card-number">{{ number_format($counters['subscribed']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-gray">
                    <div class="vironeer-counter-card-bg"></div>
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-user-minus"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ admin_trans('Unsubscribed') }}</p>
                        <p class="vironeer-counter-card-number">{{ number_format($counters['unsubscribed']) }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form class="multiple-select-search-form" action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 {{ licenseType(2) ? 'col-lg-6' : 'col-lg-8' }}">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ admin_trans('Search...') }}" value="{{ request()->input('search') ?? '' }}">
                    </div>
                    @if (licenseType(2))
                        <div class="col-12 col-lg-2">
                            <select name="subscription" class="form-select selectpicker"
                                title="{{ admin_trans('Subscription') }}">
                                <option value="1" {{ request('subscription') == '1' ? 'selected' : '' }}>
                                    {{ admin_trans('Subscribed') }}
                                </option>
                                <option value="0" {{ request('subscription') == '0' ? 'selected' : '' }}>
                                    {{ admin_trans('Unsubscribed') }}</option>
                            </select>
                        </div>
                    @endif
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ admin_trans('Status') }}">
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                {{ admin_trans('Active') }}
                            </option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                {{ admin_trans('Banned') }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.members.users.index') }}"
                            class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
            <form class="multiple-select-delete-form d-none" action="{{ route('admin.members.users.destroy.selected') }}"
                method="POST">
                @csrf
                <input type="hidden" name="delete_ids" class="multiple-select-delete-ids">
                <button class="vironeer-able-to-delete btn btn-danger"><i
                        class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete Selected') }}</button>
            </form>
        </div>
        <div>
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th class="tb-w-3x">
                                    <input class="multiple-select-check-all form-check-input" type="checkbox">
                                </th>
                                <th class="tb-w-3x">{{ admin_trans('ID') }}</th>
                                <th class="tb-w-20x">{{ admin_trans('User details') }}</th>
                                <th class="tb-w-3x text-center">{{ admin_trans('Referred by') }}</th>
                                @if (licenseType(2))
                                    <th class="tb-w-3x text-center">{{ admin_trans('Subscription') }}</th>
                                @endif
                                <th class="tb-w-2x text-center">{{ admin_trans('Email status') }}</th>
                                <th class="tb-w-2x text-center">{{ admin_trans('Account status') }}</th>
                                <th class="tb-w-3x text-center">{{ admin_trans('Registred date') }}</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <input class="form-check-input multiple-select-checkbox"
                                            data-id="{{ $user->id }}" type="checkbox">
                                    </td>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="{{ route('admin.members.users.edit', $user->id) }}">
                                                <img src="{{ asset($user->avatar) }}" alt="User" />
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="{{ route('admin.members.users.edit', $user->id) }}">{{ $user->name }}</a>
                                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->referrer)
                                            <a href="{{ route('admin.members.users.edit', $user->referrer->referring_user->id) }}"
                                                class="text-dark"><i
                                                    class="fa fa-user me-2"></i>{{ $user->referrer->referring_user->username }}</a>
                                        @else
                                            <span>--</span>
                                        @endif
                                    </td>
                                    @if (licenseType(2))
                                        <td class="text-center">
                                            @if ($user->isSubscribed())
                                                <span class="badge bg-purple">{{ admin_trans('Subscribed') }}</span>
                                            @else
                                                <span class="badge bg-gray">{{ admin_trans('Unsubscribed') }}</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-blue">{{ admin_trans('Verified') }}</span>
                                        @else
                                            <span
                                                class="badge bg-warning text-dark">{{ admin_trans('Unverified') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($user->status)
                                            <span class="badge bg-green">{{ admin_trans('Active') }}</span>
                                        @else
                                            <span class="badge bg-red">{{ admin_trans('Banned') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ dateFormat($user->created_at) }}</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button"
                                                        id="earningsDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-dollar-sign"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="earningsDropdown">
                                                        @if (licenseType(2))
                                                            @if ($user->isSubscribed())
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.premium.subscriptions.edit', $user->subscription->id) }}">
                                                                        <i class="fas fa-gem me-1"></i>
                                                                        {{ admin_trans('Subscription') }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.premium.transactions.index', 'user=' . $user->id) }}">
                                                                    <i class="fa-solid fa-file-invoice me-1"></i>
                                                                    {{ admin_trans('Transactions') }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.withdrawals.index', 'user=' . $user->id) }}">
                                                                <i class="fa-regular fa-paper-plane me-1"></i>
                                                                {{ admin_trans('Withdrawals') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.earnings.statistics.index', 'user=' . $user->id) }}">
                                                                <i class="fa-solid fa-chart-simple me-1"></i>
                                                                {{ admin_trans('Earnings Stats') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.earnings.records.index', 'user=' . $user->id) }}">
                                                                <i class="fa-solid fa-arrows-rotate me-1"></i>
                                                                {{ admin_trans('Earnings Records') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="settingsDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-list"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.members.users.edit', $user->id) }}">
                                                                <i class="fas fa-edit me-1"></i>
                                                                {{ admin_trans('Edit details') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.files.users.index', 'user=' . $user->id) }}">
                                                                <i class="fa-solid fa-upload me-1"></i>
                                                                {{ admin_trans('Uploads') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.members.users.referrals.index', $user->id) }}">
                                                                <i class="fas fa-users me-1"></i>
                                                                {{ admin_trans('Referrals') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.members.users.logs', $user->id) }}">
                                                                <i class="fas fa-list-ul me-1"></i>
                                                                {{ admin_trans('Login logs') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider" />
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.members.users.destroy', $user->id) }}"
                                                                method="POST">
                                                                @csrf @method('DELETE')
                                                                <button
                                                                    class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                                        class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete') }}</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @include('backend.partials.empty', ['class' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $users->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
