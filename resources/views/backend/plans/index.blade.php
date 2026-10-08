@extends('backend.layouts.grid')
@section('section', admin_trans('Settings'))
@section('title', admin_trans('Plans'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-7x">{{ admin_trans('Name') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Storage space') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Max File size') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('File expiration') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Download waiting time') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Upload status') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Last Update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $plan)
                    <tr>
                        <td>
                            <a href="{{ route('admin.plans.edit', $plan->id) }}">
                                @if ($plan->isForVisitors())
                                    <i class="fa-solid fa-eye fa-lg me-2"></i>
                                @else
                                    <i class="fa-solid fa-users fa-lg me-2"></i>
                                @endif
                                <span>{{ $plan->name }}</span>
                            </a>
                        </td>
                        <td>{{ $plan->storageSpaceFormatted() }}</td>
                        <td>{{ $plan->maxFileSizeFormatted() }}</td>
                        <td>{{ $plan->fileExpiryDaysFormatted() }}</td>
                        <td>{{ $plan->downloadWaitingTimeFormatted() }}</td>
                        <td>
                            @if ($plan->upload_status)
                                <span class="badge bg-green">{{ admin_trans('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($plan->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.plans.edit', $plan->id) }}"><i
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
