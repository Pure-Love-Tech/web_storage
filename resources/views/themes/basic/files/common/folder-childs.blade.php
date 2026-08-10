@if ($child->isFolder())
    <div class="d-folder">
        <div class="d-folder-btn collapsed" data-bs-toggle="collapse" data-bs-target="#collapse{{ $child->id }}">
            <div class="d-folder-arrow">
                <i class="fa fa-chevron-right"></i>
            </div>
            <div class="d-folder-icon">
                {!! $child->getFileIcon() !!}
            </div>
            <span>{{ $child->getFullName() }}</span>
        </div>
        <div id="collapse{{ $child->id }}" class="d-folder-files collapse"
            data-bs-parent="#parentFolders{{ $child->id }}">
            <div class="d-folders" id="parentFolders{{ $child->id }}">
                @foreach ($child->children as $subChild)
                    @include('themes.basic.files.common.folder-childs', ['child' => $subChild])
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="d-file">
        <div class="d-file-icon">
            {!! $child->getFileIcon() !!}
        </div>
        <a href="{{ $child->sharedLink() }}" class="d-file-name">{{ $child->getFullName() }}</a>
    </div>
@endif
