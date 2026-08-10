@extends('backend.layouts.grid')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Subscriptions'))
@section('link', route('admin.premium.subscriptions.create'))
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Active subscriptions') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['active']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ admin_trans('Expired subscriptions') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['expired']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-5">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ admin_trans('Search...') }}" value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        @include('backend.partials.users-select')
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ admin_trans('Status') }}">
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>
                                {{ admin_trans('Active') }}</option>
                            <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>
                                {{ admin_trans('Expired') }}</option>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.premium.subscriptions.index') }}"
                            class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            @if ($subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th>{{ admin_trans('ID') }}</th>
                                <th class="tb-w-20x">{{ admin_trans('User') }}</th>
                                <th>{{ admin_trans('Status') }}</th>
                                <th>{{ admin_trans('Expiry Date') }}</th>
                                <th>{{ admin_trans('Subscription Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('admin.premium.subscriptions.edit', $subscription->id) }}">#{{ $subscription->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $subscription->user->id) }}"
                                            class="text-dark"><i
                                                class="fa fa-user me-2"></i>{{ $subscription->user->name }}
                                            ({{ $subscription->user->email }})
                                        </a>
                                    </td>
                                    <td>
                                        @if ($subscription->isExpired())
                                            <span class="badge bg-red">{{ admin_trans('Expired') }}</span>
                                        @else
                                            <span class="badge bg-green">{{ admin_trans('Active') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ dateFormat($subscription->expiry_at) }}</td>
                                    <td>{{ dateFormat($subscription->created_at) }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.premium.subscriptions.edit', $subscription->id) }}"><i
                                                            class="fa-regular fa-pen-to-square me-2"></i>{{ admin_trans('Edit') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.premium.subscriptions.destroy', $subscription->id) }}"
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
            @else
                @include('backend.partials.empty', ['class' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $subscriptions->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
