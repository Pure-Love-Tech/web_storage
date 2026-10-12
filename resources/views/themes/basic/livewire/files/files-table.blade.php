<div wire:key="files-table" class="files-table">
    <div class="card-v">
        <div class="table-search">
            <div class="form-icon radius mb-4">
                <div class="icon">
                    <i class="fa fa-search"></i>
                </div>
                <input type="text" wire:model.debounce.200ms="search"
                    wire:keydown.enter="$emit('search', $event.target.value)"
                    placeholder="{{ translate('Search...', 'files') }}" class="form-control py-2 radius">
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <div class="btn-group">
                        @if ($folder)
                            <a href="{{ $folder->hasParent() ? route('user.files.index', 'folder=' . $folder->parent_id) : route('user.files.index') }}"
                                class="btn btn-outline-secondary radius">
                                <span><i class="fa-solid fa-arrow-turn-up"></i></span>
                            </a>
                        @endif
                        <button type="button" class="btn btn-outline-secondary radius" data-bs-toggle="modal"
                            data-bs-target="#createFolderModal">
                            <span><i class="fa-solid fa-folder-plus"></i>
                                <span class="d-none d-lg-inline ms-2">{{ translate('New Folder', 'files') }}</span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary radius" data-upload-btn>
                            <span><i class="fa-solid fa-upload"></i><span
                                    class="d-none d-lg-inline ms-2">{{ translate('Upload', 'files') }}</span></span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" wire:click="showMoveModal">
                            <span><i class="fa-solid fa-shuffle"></i><span
                                    class="d-none d-lg-inline ms-2">{{ translate('Move', 'files') }}</span></span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" wire:click="refreshEntries">
                            <span><i class="fa-solid fa-rotate"></i><span
                                    class="d-none d-lg-inline ms-2">{{ translate('Refresh', 'files') }}</span></span>
                        </button>
                        <button type="button" class="btn btn-outline-danger radius" wire:click="deleteMultipleConfirm">
                            <span><i class="fa-regular fa-trash-can"></i><span
                                    class="d-none d-lg-inline ms-2">{{ translate('Delete', 'files') }}</span></span>
                        </button>
                    </div>
                </div>
                <div class="col-auto">
                    <div wire:loading>
                        <div class="spinner-border spinner-border-sm text-muted" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dash-table">
            <table class="table text-center table-borderless align-middle">
                <thead>
                    <tr>
                        <th class="text-start">
                            <div class="form-check files-table-select">
                                <input class="form-check-input" type="checkbox" wire:model="selectAllRows">
                            </div>
                        </th>
                        <th class="text-start">{{ translate('Name', 'files') }}</th>
                        <th>{{ translate('Size', 'files') }}</th>
                        <th>{{ translate('Uploaded date', 'files') }}</th>
                        <th>{{ translate('Visibility', 'files') }}</th>
                        <th class="text-end">{{ translate('Action', 'files') }}</th>
                    </tr>
                </thead>
                <tbody class="text-muted">
                    @forelse ($fileEntries as $fileEntry)
                        <tr>
                            <td class="text-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedRows"
                                        wire:key="row-{{ $fileEntry->id }}" value="{{ $fileEntry->id }}"
                                        id="checkbox-{{ $fileEntry->id }}" x-ref="checkboxes"
                                        {{ $selectAllRows ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-start">
                                @if ($fileEntry->isFolder())
                                    <a href="{{ route('user.files.index', 'folder=' . $fileEntry->id) }}"
                                        class="file-name">
                                        <div class="file-name-icon">
                                            {!! $fileEntry->getFileIcon('fa-2x') !!}
                                        </div>
                                        <div class="file-name-info">
                                            <p class="file-name-title">{{ $fileEntry->getFullName() }}</p>
                                            <p class="file-name-text text-muted">
                                                @php
                                                    $countFolders = $fileEntry->countFoldersRecursive();
                                                    $countFiles = $fileEntry->countFilesRecursive();
                                                @endphp
                                                <span>
                                                    @if ($countFolders != 1)
                                                        {{ str(translate('{count} Folders', 'files'))->replace('{count}', $countFolders) }}
                                                    @else
                                                        {{ str(translate('{count} Folder', 'files'))->replace('{count}', $countFolders) }}
                                                    @endif
                                                </span>,
                                                <span>
                                                    @if ($countFiles != 1)
                                                        {{ str(translate('{count} Files', 'files'))->replace('{count}', $countFiles) }}
                                                    @else
                                                        {{ str(translate('{count} File', 'files'))->replace('{count}', $countFiles) }}
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                    </a>
                                @else
                                    <div class="file-name">
                                        <div class="file-name-icon">
                                            {!! $fileEntry->getFileIcon('vi-sm') !!}
                                        </div>
                                        <div class="file-name-info">
                                            <p class="file-name-title">{{ $fileEntry->getFullName() }}</p>
                                            <p class="file-name-text text-muted">{{ $fileEntry->mime }}</p>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $fileEntry->getFullSize() }}</td>
                            <td>{{ dateFormat($fileEntry->created_at) }}</td>
                            <td>{{ $fileEntry->visibility() }}</td>
                            <td class="text-end">
                                <div class="dropdown position-static custom-drop">
                                    <a class="dropdown-btn" type="button" id="dropdown-menu-{{ $fileEntry->id }}"
                                        data-bs-toggle="dropdown">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdown-menu-{{ $fileEntry->id }}">
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                wire:click.prevent="$emit('shareFileEntry', {{ $fileEntry->id }})"><i
                                                    class="fa-solid fa-share-nodes"></i>{{ translate('Share', 'files') }}</a>
                                        </li>
                                        @if ($fileEntry->isFile())
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.files.statistics', $fileEntry->id) }}"><i
                                                        class="fa-solid fa-chart-simple"></i>{{ translate('Statistics', 'files') }}</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.files.download', [$fileEntry->sharedId(), $fileEntry->getFullName()]) }}"><i
                                                        class="fa-solid fa-download"></i>{{ translate('Download', 'files') }}</a>
                                            </li>
                                        @endif
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                wire:click.prevent="$emit('editFileEntry', {{ $fileEntry->id }})"><i
                                                    class="fa-solid fa-pen-to-square"></i>{{ translate('Edit details', 'files') }}</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                wire:click.prevent="showMoveModal({{ $fileEntry->id }})"><i
                                                    class="fa-solid fa-shuffle"></i>{{ translate('Move to', 'files') }}</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)"
                                                wire:click.prevent="deleteOneConfirm({{ $fileEntry->id }})"><i
                                                    class="fa-regular fa-trash-can"></i>{{ translate('Delete', 'files') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="py-2">{{ translate('You do not have any files or folders', 'files') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $fileEntries->links() }}
    </div>
</div>
