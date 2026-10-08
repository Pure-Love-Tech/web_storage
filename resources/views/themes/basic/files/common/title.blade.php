<div class="mb-4">
    <div class="file-title mb-4">
        <div class="row row-cols-auto justify-content-center text-center g-2">
            <div class="col">
                <span class="text-primary h3">{{ translate('Download File', 'download pages') }}</span>
            </div>
            <div class="col">
                <span class="text-break h3">{{ $fileEntry->getFullName() }}</span>
            </div>
        </div>
    </div>
    <div class="file-request">
        <div class="row row-cols-auto justify-content-center text-center gx-2 gy-3">
            <div class="col">
                <span>{{ translate('You have requested', 'download pages') }}</span>
            </div>
            <div class="col">
                <span class="text-break text-primary">{{ $fileEntry->sharedLink() }}</span>
            </div>
            <div class="col">
                <span>({{ $fileEntry->getFullSize() }})</span>
            </div>
        </div>
    </div>
</div>
