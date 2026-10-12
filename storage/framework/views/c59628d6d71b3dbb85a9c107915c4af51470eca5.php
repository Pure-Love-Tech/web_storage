<div wire:key="files-table" class="files-table">
    <div class="card-v">
        <div class="table-search">
            <div class="form-icon radius mb-4">
                <div class="icon">
                    <i class="fa fa-search"></i>
                </div>
                <input type="text" wire:model.debounce.200ms="search"
                    wire:keydown.enter="$emit('search', $event.target.value)"
                    placeholder="<?php echo e(translate('Search...', 'files')); ?>" class="form-control py-2 radius">
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <div class="btn-group">
                        <?php if($folder): ?>
                            <a href="<?php echo e($folder->hasParent() ? route('user.files.index', 'folder=' . $folder->parent_id) : route('user.files.index')); ?>"
                                class="btn btn-outline-secondary radius">
                                <span><i class="fa-solid fa-arrow-turn-up"></i></span>
                            </a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline-secondary radius" data-bs-toggle="modal"
                            data-bs-target="#createFolderModal">
                            <span><i class="fa-solid fa-folder-plus"></i>
                                <span class="d-none d-lg-inline ms-2"><?php echo e(translate('New Folder', 'files')); ?></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary radius" data-upload-btn>
                            <span><i class="fa-solid fa-upload"></i><span
                                    class="d-none d-lg-inline ms-2"><?php echo e(translate('Upload', 'files')); ?></span></span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" wire:click="showMoveModal">
                            <span><i class="fa-solid fa-shuffle"></i><span
                                    class="d-none d-lg-inline ms-2"><?php echo e(translate('Move', 'files')); ?></span></span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" wire:click="refreshEntries">
                            <span><i class="fa-solid fa-rotate"></i><span
                                    class="d-none d-lg-inline ms-2"><?php echo e(translate('Refresh', 'files')); ?></span></span>
                        </button>
                        <button type="button" class="btn btn-outline-danger radius" wire:click="deleteMultipleConfirm">
                            <span><i class="fa-regular fa-trash-can"></i><span
                                    class="d-none d-lg-inline ms-2"><?php echo e(translate('Delete', 'files')); ?></span></span>
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
                        <th class="text-start"><?php echo e(translate('Name', 'files')); ?></th>
                        <th><?php echo e(translate('Size', 'files')); ?></th>
                        <th><?php echo e(translate('Uploaded date', 'files')); ?></th>
                        <th><?php echo e(translate('Visibility', 'files')); ?></th>
                        <th class="text-end"><?php echo e(translate('Action', 'files')); ?></th>
                    </tr>
                </thead>
                <tbody class="text-muted">
                    <?php $__empty_1 = true; $__currentLoopData = $fileEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedRows"
                                        wire:key="row-<?php echo e($fileEntry->id); ?>" value="<?php echo e($fileEntry->id); ?>"
                                        id="checkbox-<?php echo e($fileEntry->id); ?>" x-ref="checkboxes"
                                        <?php echo e($selectAllRows ? 'checked' : ''); ?>>
                                </div>
                            </td>
                            <td class="text-start">
                                <?php if($fileEntry->isFolder()): ?>
                                    <a href="<?php echo e(route('user.files.index', 'folder=' . $fileEntry->id)); ?>"
                                        class="file-name">
                                        <div class="file-name-icon">
                                            <?php echo $fileEntry->getFileIcon('fa-2x'); ?>

                                        </div>
                                        <div class="file-name-info">
                                            <p class="file-name-title"><?php echo e($fileEntry->getFullName()); ?></p>
                                            <p class="file-name-text text-muted">
                                                <?php
                                                    $countFolders = $fileEntry->countFoldersRecursive();
                                                    $countFiles = $fileEntry->countFilesRecursive();
                                                ?>
                                                <span>
                                                    <?php if($countFolders != 1): ?>
                                                        <?php echo e(str(translate('{count} Folders', 'files'))->replace('{count}', $countFolders)); ?>

                                                    <?php else: ?>
                                                        <?php echo e(str(translate('{count} Folder', 'files'))->replace('{count}', $countFolders)); ?>

                                                    <?php endif; ?>
                                                </span>,
                                                <span>
                                                    <?php if($countFiles != 1): ?>
                                                        <?php echo e(str(translate('{count} Files', 'files'))->replace('{count}', $countFiles)); ?>

                                                    <?php else: ?>
                                                        <?php echo e(str(translate('{count} File', 'files'))->replace('{count}', $countFiles)); ?>

                                                    <?php endif; ?>
                                                </span>
                                            </p>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <div class="file-name">
                                        <div class="file-name-icon">
                                            <?php echo $fileEntry->getFileIcon('vi-sm'); ?>

                                        </div>
                                        <div class="file-name-info">
                                            <p class="file-name-title"><?php echo e($fileEntry->getFullName()); ?></p>
                                            <p class="file-name-text text-muted"><?php echo e($fileEntry->mime); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($fileEntry->getFullSize()); ?></td>
                            <td><?php echo e(dateFormat($fileEntry->created_at)); ?></td>
                            <td><?php echo e($fileEntry->visibility()); ?></td>
                            <td class="text-end">
                                <div class="dropdown position-static custom-drop">
                                    <a class="dropdown-btn" type="button" id="dropdown-menu-<?php echo e($fileEntry->id); ?>"
                                        data-bs-toggle="dropdown">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdown-menu-<?php echo e($fileEntry->id); ?>">
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                wire:click.prevent="$emit('shareFileEntry', <?php echo e($fileEntry->id); ?>)"><i
                                                    class="fa-solid fa-share-nodes"></i><?php echo e(translate('Share', 'files')); ?></a>
                                        </li>
                                        <?php if($fileEntry->isFile()): ?>
                                            <li><a class="dropdown-item"
                                                    href="<?php echo e(route('user.files.statistics', $fileEntry->id)); ?>"><i
                                                        class="fa-solid fa-chart-simple"></i><?php echo e(translate('Statistics', 'files')); ?></a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="<?php echo e(route('user.files.download', [$fileEntry->sharedId(), $fileEntry->getFullName()])); ?>"><i
                                                        class="fa-solid fa-download"></i><?php echo e(translate('Download', 'files')); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                wire:click.prevent="$emit('editFileEntry', <?php echo e($fileEntry->id); ?>)"><i
                                                    class="fa-solid fa-pen-to-square"></i><?php echo e(translate('Edit details', 'files')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)"
                                                wire:click.prevent="showMoveModal(<?php echo e($fileEntry->id); ?>)"><i
                                                    class="fa-solid fa-shuffle"></i><?php echo e(translate('Move to', 'files')); ?></a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)"
                                                wire:click.prevent="deleteOneConfirm(<?php echo e($fileEntry->id); ?>)"><i
                                                    class="fa-regular fa-trash-can"></i><?php echo e(translate('Delete', 'files')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="py-2"><?php echo e(translate('You do not have any files or folders', 'files')); ?>

                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($fileEntries->links()); ?>

    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/livewire/files/files-table.blade.php ENDPATH**/ ?>