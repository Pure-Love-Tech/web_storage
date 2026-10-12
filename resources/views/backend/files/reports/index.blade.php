@extends('backend.layouts.grid')
@section('title', admin_trans('Reported files'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-3x">#</th>
                    <th class="tb-w-20x">{{ admin_trans('Reported file') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Reported by') }}</th>
                    <th class="tb-w-3x">{{ admin_trans('Reason') }}</th>
                    <th class="tb-w-7x">{{ admin_trans('Date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fileReports as $fileReport)
                    <tr class="item">
                        <td>
                            <a href="{{ route('admin.files.reports.show', $fileReport->id) }}">
                                #{{ $fileReport->id }}
                            </a>
                        </td>
                        <td>
                            <div class="vironeer-content-box">
                                @php
                                    $fileEntry = $fileReport->file_entry;
                                    $link = route($fileEntry->user_id ? 'admin.files.users.show' : 'admin.files.visitors.show', $fileEntry->id);
                                @endphp
                                <a class="vironeer-content-image text-center"
                                    href="{{ route('admin.files.reports.show', $fileReport->id) }}">
                                    {!! $fileEntry->getFileIcon() !!}
                                </a>
                                <div>
                                    <a class="text-reset" href="{{ $link }}">
                                        {{ shortertext($fileEntry->getFullName(), 50) }}
                                    </a>
                                    <p class="text-muted mb-0">
                                        {{ shortertext($fileEntry->mime, 50) ?? admin_trans('Unknown') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="vironeer-content-box">
                                <div>
                                    <span>{{ shortertext($fileReport->name, 30) }}</span>
                                    <p class="text-muted mb-0">{{ shortertext($fileReport->email, 30) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ shortertext(\App\Models\FileReport::reasons()[$fileReport->reason], 25) }}</td>
                        <td>{{ dateFormat($fileReport->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end dropdown-menu-lg"
                                    data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.files.reports.show', $fileReport->id) }}">
                                            <i class="fa-regular fa-eye"></i>
                                            {{ admin_trans('View') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.files.reports.destroy', $fileReport->id) }}"
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
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
@endsection
