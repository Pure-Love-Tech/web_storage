@extends('backend.layouts.grid')
@section('title', admin_trans('Extensions'))
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
                @foreach ($extensions as $extension)
                    <tr class="item">
                        <td>{{ $extension->id }}</td>
                        <td>
                            <a href="{{ route('admin.settings.extensions.edit', $extension->id) }}">
                                <img src="{{ asset($extension->logo) }}" height="40" width="40">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.settings.extensions.edit', $extension->id) }}" class="text-dark">
                                {{ $extension->name }}
                            </a>
                        </td>
                        <td>
                            @if ($extension->status)
                                <span class="badge bg-success">{{ admin_trans('Enabled') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($extension->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.settings.extensions.edit', $extension->id) }}"><i
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
