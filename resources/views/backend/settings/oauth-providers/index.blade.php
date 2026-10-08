@extends('backend.layouts.grid')
@section('section', admin_trans('Settings'))
@section('title', admin_trans('OAuth Providers'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-1x">{{ admin_trans('#') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('name') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Status') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Last Update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($oauthProviders as $oauthProvider)
                    <tr class="item">
                        <td>{{ $oauthProvider->id }}</td>
                        <td>
                            <a href="{{ route('admin.settings.oauth-providers.edit', $oauthProvider->id) }}"
                                class="text-dark">
                                <i class="{{ $oauthProvider->icon }} me-2"></i>
                                {{ $oauthProvider->name }}
                            </a>
                        </td>
                        <td>
                            @if ($oauthProvider->isActive())
                                <span class="badge bg-success">{{ admin_trans('Enabled') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($oauthProvider->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.settings.oauth-providers.edit', $oauthProvider->id) }}"><i
                                                class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
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
