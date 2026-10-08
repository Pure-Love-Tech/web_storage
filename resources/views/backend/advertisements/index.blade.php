@extends('backend.layouts.grid')
@section('title', admin_trans('advertisements'))
@section('content')
    <div class="card ratings">
        <table class="table unsort-datatable w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">#</th>
                    <th class="tb-w-7x">{{ admin_trans('Position') }}</th>
                    <th class="tb-w-5x">{{ admin_trans('Size') }}</th>
                    <th class="tb-w-5x">{{ admin_trans('Status') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Last update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($advertisements as $advertisement)
                    <tr>
                        <td>{{ $advertisement->id }}</td>
                        <td>
                            <a href="{{ route('admin.advertisements.edit', $advertisement->id) }}" class="text-dark">
                                <i class="fas fa-ad me-2"></i>{{ $advertisement->position }}
                            </a>
                        </td>
                        <td>{{ $advertisement->size ?? '--' }}</td>
                        <td>
                            @if ($advertisement->status)
                                <span class="badge bg-success">{{ admin_trans('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($advertisement->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.advertisements.edit', $advertisement->id) }}"><i
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
