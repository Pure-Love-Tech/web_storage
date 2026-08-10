<div class="mt-5">
    @if ($fileEntry->isFolder())
        <h5 class="text-secondary mb-3">
            {{ str(translate('About {folder_name}', 'folder page'))->replace('{folder_name}', $fileEntry->getFullName()) }}
        </h5>
        <p class="mb-0">
            @if ($fileEntry->description)
                {{ $fileEntry->description }}
            @else
                @php
                    $replaceFrom = ['{website_name}', '{folder_name}'];
                    $replaceTo = [settings('general')->site_name, $fileEntry->getFullName()];
                    $description = str(translate('folder description', 'folder page'))->replace($replaceFrom, $replaceTo);
                @endphp
                {{ $description }}
            @endif
        </p>
    @else
        <h5 class="text-secondary mb-3">
            {{ str(translate('About {file_name}', 'download pages'))->replace('{file_name}', $fileEntry->getFullName()) }}
        </h5>
        <p class="mb-0">
            @if ($fileEntry->description)
                {{ $fileEntry->description }}
            @else
                @php
                    $replaceFrom = ['{website_name}', '{file_name}', '{file_extension}'];
                    $replaceTo = [settings('general')->site_name, $fileEntry->getFullName(), strtoupper($fileEntry->extension)];
                    $description = str(translate('file description', 'download pages'))->replace($replaceFrom, $replaceTo);
                @endphp
                {{ $description }}
            @endif
        </p>
    @endif
</div>
<div class="file-links mt-5">
    @if ($fileEntry->isFolder())
        <nav class="nav nav-pills custom-nav-pills" id="pills-tab" role="tablist">
            <a class="nav-link active" id="pills-link-tab" data-bs-toggle="pill" href="#pills-link" role="tab"
                aria-controls="pills-home" aria-selected="true">
                <i class="fa-solid fa-share-from-square me-1"></i>
                {{ translate('Share Link', 'folder page') }}
            </a>
            <a class="nav-link" id="pills-forum-tab" data-bs-toggle="pill" href="#pills-forum" role="tab"
                aria-controls="pills-profile" aria-selected="false">
                <i class="fa fa-code me-1"></i>
                {{ translate('Forum Code', 'folder page') }}
            </a>
            <a class="nav-link" id="pills-html-tab" data-bs-toggle="pill" href="#pills-html" role="tab">
                <i class="fab fa-html5 me-1"></i>
                {{ translate('HTML Code', 'folder page') }}
            </a>
        </nav>
    @else
        <nav class="nav nav-pills custom-nav-pills" id="pills-tab" role="tablist">
            <a class="nav-link active" id="pills-link-tab" data-bs-toggle="pill" href="#pills-link" role="tab"
                aria-controls="pills-home" aria-selected="true">
                <i class="fa fa-download me-1"></i>
                {{ translate('Download Link', 'download pages') }}
            </a>
            <a class="nav-link" id="pills-forum-tab" data-bs-toggle="pill" href="#pills-forum" role="tab"
                aria-controls="pills-profile" aria-selected="false">
                <i class="fa fa-code me-1"></i>
                {{ translate('Forum Code', 'download pages') }}
            </a>
            <a class="nav-link" id="pills-html-tab" data-bs-toggle="pill" href="#pills-html" role="tab">
                <i class="fab fa-html5 me-1"></i>
                {{ translate('HTML Code', 'download pages') }}
            </a>
        </nav>
    @endif
    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-link" role="tabpanel" aria-labelledby="pills-home-tab">
            <textarea class="form-control" rows="4">{{ $fileEntry->sharedLink() }}</textarea>
        </div>
        <div class="tab-pane fade" id="pills-forum" role="tabpanel" aria-labelledby="pills-profile-tab">
            <textarea class="form-control" rows="4">[URL={{ $fileEntry->sharedLink() }}]{{ $fileEntry->getFullName() }}[/URL]</textarea>
        </div>
        <div class="tab-pane fade" id="pills-html" role="tabpanel" aria-labelledby="pills-disabled-tab">
            <textarea class="form-control" rows="4"><a href="{{ $fileEntry->sharedLink() }}">{{ $fileEntry->getFullName() }}</a></textarea>
        </div>
    </div>
</div>
