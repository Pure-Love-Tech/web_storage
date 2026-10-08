@extends('backend.layouts.grid')
@section('title', admin_trans('Users files'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-2 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-primary">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">
                        {{ admin_trans('Total files') }}
                    </p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_files']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-secondary">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-hard-drive"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">
                        {{ admin_trans('Used space') }}
                    </p>
                    <p class="vironeer-counter-card-number">{{ formatBytes($counters['used_space']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form class="multiple-select-search-form" action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-12">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ admin_trans('Search...') }}" value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-4">
                        <input type="text" name="shared_id" class="form-control"
                            placeholder="{{ admin_trans('Shared id') }}" value="{{ request('shared_id') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-4">
                        @include('backend.partials.users-select')
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="visibility" class="form-select selectpicker" title="{{ admin_trans('Visibility') }}"
                            data-live-search="true">
                            @foreach (\App\Models\FileEntry::getVisibilityOptions() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ request('visibility') == "{$key}" ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.files.users.index') }}"
                            class="btn btn-secondary w-100">{{ admin_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
            <form class="multiple-select-delete-form d-none" action="{{ route('admin.files.users.destroy.selected') }}"
                method="POST">
                @csrf
                <input type="hidden" name="delete_ids" class="multiple-select-delete-ids">
                <button class="vironeer-able-to-delete btn btn-danger"><i
                        class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete Selected') }}</button>
            </form>
        </div>
        <div>
            @if ($fileEntries->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th class="tb-w-3x">
                                    <input class="multiple-select-check-all form-check-input" type="checkbox">
                                </th>
                                <th class="tb-w-20x">{{ admin_trans('File details') }}</th>
                                <th class="tb-w-2x">{{ admin_trans('File size') }}</th>
                                <th class="tb-w-3x text-center">{{ admin_trans('Downloads') }}</th>
                                <th class="tb-w-3x text-center">{{ admin_trans('Uploaded by') }}</th>
                                <th class="tb-w-7x text-center">{{ admin_trans('Storage') }}</th>
                                <th class="tb-w-3x text-center">{{ admin_trans('Visibility') }}</th>
                                <th class="tb-w-3x text-center">{{ admin_trans('Uploaded Date') }}</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fileEntries as $fileEntry)
                                <tr>
                                    <td>
                                        <input class="form-check-input multiple-select-checkbox"
                                            data-id="{{ $fileEntry->id }}" type="checkbox">
                                    </td>
                                    <td>
                                        <div class="vironeer-content-box">
                                            <a class="vironeer-content-image text-center"
                                                href="{{ route('admin.files.users.show', $fileEntry->id) }}">
                                                {!! $fileEntry->getFileIcon() !!}
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="{{ route('admin.files.users.show', $fileEntry->id) }}">{{ shortertext($fileEntry->getFullName(), 50) }}</a>
                                                <p class="text-muted mb-0">
                                                    {{ shortertext($fileEntry->mime, 50) ?? admin_trans('Unknown') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $fileEntry->getFullSize() }}</td>
                                    <td class="text-center">{{ formatNumber($fileEntry->downloads) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.members.users.edit', $fileEntry->user->id) }}">
                                            <i class="fa fa-user me-2"></i>
                                            {{ $fileEntry->user->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($fileEntry->storageProvider->isLocal())
                                            <span><i
                                                    class="fas fa-server me-2"></i>{{ $fileEntry->storageProvider->alias }}</span>
                                        @else
                                            <a class="text-dark capitalize"
                                                href="{{ route('admin.settings.storage.edit', $fileEntry->storageProvider->id) }}">
                                                <i class="fas fa-server me-2"></i>
                                                {{ $fileEntry->storageProvider->alias }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $fileEntry->visibility() }}</td>
                                    <td class="text-center">{{ dateFormat($fileEntry->created_at) }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-md-end dropdown-menu-lg"
                                                data-popper-placement="bottom-end">
                                                @if ($fileEntry->isPublic())
                                                    <li>
                                                        <a class="dropdown-item" target="_blank"
                                                            href="{{ $fileEntry->sharedLink() }}"><i
                                                                class="fas fa-external-link-alt me-2"></i>{{ admin_trans('Preview') }}</a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('admin.files.users.statistics', $fileEntry->id) }}"><i
                                                            class="fa-solid fa-chart-simple me-2"></i>{{ admin_trans('Statistics') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.files.users.download', [$fileEntry->id, $fileEntry->getFullName()]) }}"><i
                                                            class="fas fa-download me-2"></i>{{ admin_trans('Download') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.files.users.show', $fileEntry->id) }}"><i
                                                            class="fas fa-desktop me-2"></i>{{ admin_trans('File details') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.files.users.destroy', $fileEntry->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="vironeer-able-to-delete dropdown-item text-danger"><i
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
    {{ $fileEntries->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
