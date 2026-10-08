@extends('backend.layouts.grid')
@section('title', admin_trans('Storage Providers'))
@section('section', admin_trans('Settings'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-1x">{{ admin_trans('#') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Logo') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('name') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('Status') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('Last Update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($storageProviders as $storageProvider)
                    <tr class="item">
                        <td>{{ $storageProvider->id }}</td>
                        <td>
                            @if (!$storageProvider->isLocal())
                                <a href="{{ route('admin.settings.storage.edit', $storageProvider->id) }}">
                                    <img src="{{ asset($storageProvider->logo) }}" height="40" width="40">
                                </a>
                            @else
                                <img src="{{ asset($storageProvider->logo) }}" height="40" width="40">
                            @endif
                        </td>
                        <td>
                            @if ($storageProvider->isLocal())
                                <span>
                                    {{ $storageProvider->name }}
                                    {{ $storageProvider->isDefault() ? admin_trans('(Default)') : '' }}
                                </span>
                            @else
                                <a href="{{ route('admin.settings.storage.edit', $storageProvider->id) }}"
                                    class="text-dark">
                                    {{ $storageProvider->name }}
                                    {{ $storageProvider->isDefault() ? admin_trans('(Default)') : '' }}
                                </a>
                            @endif
                            @if (demoMode() && isAddonActive($storageProvider->alias))
                                <span class="badge bg-c-1 ms-2">{{ admin_trans('Addon') }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($storageProvider->status)
                                <span class="badge bg-success">{{ admin_trans('Enabled') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($storageProvider->updated_at) }}</td>
                        <td>
                            @if (!$storageProvider->isLocal() || !$storageProvider->isDefault())
                                <div class="text-end">
                                    <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                        @if (!$storageProvider->isLocal())
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.settings.storage.edit', $storageProvider->id) }}"><i
                                                        class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                        @endif
                                        @if (!$storageProvider->isDefault())
                                            <li>
                                                <form
                                                    action="{{ route('admin.settings.storage.default', $storageProvider->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="vironeer-form-confirm dropdown-item"><i
                                                            class="fas fa-thumbtack me-2"></i>{{ admin_trans('Set As Default') }}</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
