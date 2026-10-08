@extends('backend.layouts.grid')
@section('title', $active . ' | ' . admin_trans('Announcements'))
@section('link', route('admin.announcements.create'))
@section('language', true)
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ admin_trans('#') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Language') }}</th>
                    <th class="tb-w-15x">{{ admin_trans('Title') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Status') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('Published date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->id }}</td>
                        <td><a href="{{ route('admin.settings.languages.translates', $announcement->lang) }}"><i
                                    class="fas fa-language me-2"></i>{{ $announcement->language->name }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="text-dark"><i
                                    class="fas fa-bullhorn me-2"></i>{{ shortertext($announcement->title, 50) }}</a>
                        </td>
                        <td>
                            @if ($announcement->status)
                                <span class="badge bg-success">{{ admin_trans('Public') }}</span>
                            @else
                                <span class="badge bg-danger">{{ admin_trans('Private') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($announcement->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.announcements.edit', $announcement->id) }}"><i
                                                class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}"
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
@endsection
