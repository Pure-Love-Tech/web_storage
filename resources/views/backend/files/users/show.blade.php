@extends('backend.layouts.grid')
@section('title', admin_trans('Users files') . ' | #' . $fileEntry->id)
@section('back', route('admin.files.users.index'))
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.members.users.edit', $fileEntry->user->id) }}">
                        <img class="border rounded-circle border-2" src="{{ asset($fileEntry->user->avatar) }}" width="60"
                            height="60">
                    </a>
                </div>
                <div class="flex-grow-1 ms-3">
                    <a href="{{ route('admin.members.users.edit', $fileEntry->user->id) }}" class="text-dark">
                        <h5 class="mb-1">{{ $fileEntry->user->name }}</h5>
                        <p class="mb-0 text-muted">{{ $fileEntry->user->email }}</p>
                    </a>
                </div>
                <div class="flex-grow-3 ms-3">
                    <a href="{{ route('admin.members.users.edit', $fileEntry->user->id) }}" class="btn btn-primary"
                        target="_blank"><i class="fa fa-eye me-2"></i>{{ admin_trans('View details') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="file d-flex h-100 justify-content-center align-items-center">
                        <div class="p-5">
                            <div class="mb-3">
                                {!! $fileEntry->getFileIcon('vi-4x') !!}
                            </div>
                            <h4>{{ shortertext($fileEntry->getFullName(), 50) }}</h4>
                            <h5 class="text-muted">{{ $fileEntry->getFullSize() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <ul class="custom-list-group list-group list-group-flush">
                    <li class="list-group-item">
                        @if ($fileEntry->isPrivate())
                            <div class="alert alert-danger text-center">
                                <i class="fa-regular fa-circle-question me-1"></i>
                                {{ admin_trans('Private files cannot be previewed') }}
                            </div>
                        @endif
                        <a href="{{ $fileEntry->isPrivate() ? '#' : $fileEntry->sharedLInk() }}" target="_blank"
                            class="btn btn-blue btn-lg w-100 mb-3 {{ $fileEntry->isPrivate() ? 'disabled' : '' }}"><i
                                class="fas fa-external-link-alt me-2"></i>{{ admin_trans('Preview') }}</a>
                        <a href="{{ route('admin.files.users.statistics', $fileEntry->id) }}"
                            class="btn btn-warning btn-lg w-100 mb-3 {{ $fileEntry->isPrivate() ? 'disabled' : '' }}"><i
                                class="fa-solid fa-chart-simple me-2"></i>{{ admin_trans('Statistics') }}</a>
                        <a href="{{ route('admin.files.users.download', [$fileEntry->id, $fileEntry->getFullName()]) }}"
                            class="btn btn-success btn-lg w-100 mb-3"><i
                                class="fas fa-download me-2"></i>{{ admin_trans('Download') }}</a>
                        <button class="btn btn-dark btn-lg w-100 mb-3" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fa fa-edit me-2"></i>
                            {{ admin_trans('Edit details') }}
                        </button>
                        <form action="{{ route('admin.files.users.destroy', $fileEntry->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="vironeer-able-to-delete btn btn-danger btn-lg w-100"><i
                                    class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete') }}</button>
                        </form>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>{{ admin_trans('Name') }}</strong>
                        <span>{{ shortertext($fileEntry->getFullName(), 30) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>{{ admin_trans('Shared id') }}</strong>
                        <span>{{ $fileEntry->sharedId() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>{{ admin_trans('Size') }}</strong>
                        <span>{{ $fileEntry->getFullSize() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>{{ admin_trans('Storage') }}</strong>
                        <span>
                            @if ($fileEntry->storageProvider->isLocal())
                                <span>
                                    <i class="fas fa-server me-2"></i>
                                    {{ $fileEntry->storageProvider->alias }}
                                </span>
                            @else
                                <a class="text-dark capitalize"
                                    href="{{ route('admin.settings.storage.edit', $fileEntry->storageProvider->id) }}">
                                    <i class="fas fa-server me-2"></i>
                                    {{ $fileEntry->storageProvider->alias }}
                                </a>
                            @endif
                        </span>
                    </li>
                    @if ($fileEntry->ip)
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>{{ admin_trans('IP Address') }}</strong>
                            @if (!demoMode())
                                @if ($fileEntry->ip)
                                    <a href="{{ route('admin.members.users.logsbyip', $fileEntry->ip) }}"><i
                                            class="fa-solid fa-location-dot me-2"></i>{{ $fileEntry->ip }}</a>
                                @else
                                    <span>--</span>
                                @endif
                            @else
                                <span>{{ admin_trans('Hidden in demo') }}</span>
                            @endif
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>{{ admin_trans('Visibility') }}</strong>
                        <span>{{ $fileEntry->visibility() }}</span>
                    </li>
                    @if ($fileEntry->password)
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>{{ admin_trans('Password') }}</strong>
                            <span>{{ demoMode() ? admin_trans('Hidden in demo') : $fileEntry->password }}</span>
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>{{ admin_trans('Uploaded date') }}</strong>
                        <span>{{ dateFormat($fileEntry->created_at) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fa fa-edit me-2"></i>
                        {{ admin_trans('Edit file details') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.files.users.update', $fileEntry->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Name') }}</label>
                            <input type="text" name="name" class="form-control form-control-lg"
                                value="{{ $fileEntry->name }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Visibility', 'forms') }}</label>
                            <select name="visibility" class="form-select form-select-lg">
                                @foreach (\App\Models\FileEntry::getVisibilityOptions() as $visibilityOptionKey => $visibilityOptionValue)
                                    <option value="{{ $visibilityOptionKey }}"
                                        {{ $visibilityOptionKey == $fileEntry->visibility ? 'selected' : '' }}>
                                        {{ $visibilityOptionValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Password') }}</label>
                            <input type="text" name="password" class="form-control form-control-lg"
                                value="{{ $fileEntry->password }}" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ admin_trans('Description') }}</label>
                            <textarea name="description" class="form-control" rows="4">{{ $fileEntry->description }}</textarea>
                        </div>
                        <button class="btn btn-primary btn-lg w-100">{{ admin_trans('Save changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
@endsection
