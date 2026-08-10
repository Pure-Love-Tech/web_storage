@extends('themes.basic.layouts.single')
@section('section', translate('Folder', 'folder page'))
@section('title', $fileEntry->name)
@section('hide_header', true)
@section('content')
    <div class="section">
        <div class="container">
            <div class="section-inner">
                <div class="custom-container">
                    <div class="section-body">
                        <div class="mb-5">
                            <div class="file-title mb-4">
                                <div class="row row-cols-auto justify-content-center text-center g-2">
                                    <div class="col">
                                        <span class="text-primary h3">{{ translate('Folder', 'folder page') }}</span>
                                    </div>
                                    <div class="col">
                                        <span class="text-break h3">{{ $fileEntry->getFullPathAttribute() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="file-request">
                                <div class="row row-cols-auto justify-content-center text-center gx-2 gy-3">
                                    <div class="col">
                                        <span>{{ translate('You have requested', 'folder page') }}</span>
                                    </div>
                                    <div class="col">
                                        <span class="text-break text-primary">{{ $fileEntry->sharedLink() }}</span>
                                    </div>
                                    @if ($fileEntry->getFullSize())
                                        <div class="col">
                                            <span>({{ $fileEntry->getFullSize() }})</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <x-ad alias="folder_page_top" @class('ad-970x250 mb-4') />
                        <div class="file-card">
                            @if ($fileEntry->children->count() > 0)
                                <div class="d-folders" id="parentFolders">
                                    @foreach ($fileEntry->children as $child)
                                        @if ($child->isFolder())
                                            <div class="d-folder">
                                                <div class="d-folder-btn collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $child->id }}">
                                                    <div class="d-folder-arrow">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </div>
                                                    <div class="d-folder-icon">
                                                        {!! $child->getFileIcon() !!}
                                                    </div>
                                                    <span>{{ $child->getFullName() }}</span>
                                                </div>
                                                <div id="collapse{{ $child->id }}" class="d-folder-files collapse"
                                                    data-bs-parent="#parentFolders">
                                                    @foreach ($child->children as $subChild)
                                                        @include(
                                                            'themes.basic.files.common.folder-childs',
                                                            ['child' => $subChild]
                                                        )
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-file">
                                                <div class="d-file-icon">
                                                    {!! $child->getFileIcon() !!}
                                                </div>
                                                <a href="{{ $child->sharedLink() }}"
                                                    class="d-file-name">{{ $child->getFullName() }}</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted py-5 text-center">
                                    <div class="mb-2">
                                        <i class="fa-regular fa-folder-open fa-2x"></i>
                                    </div>
                                    <p class="mb-0">{{ translate('This folder is empty', 'folder page') }}</p>
                                </div>
                            @endif
                            @if ($themeSettings->folder_page->folder_about)
                                @include('themes.basic.files.common.about', [
                                    'fileEntry' => $fileEntry,
                                ])
                            @endif
                        </div>
                        <x-ad alias="folder_page_bottom" @class('ad-970x250 mt-5') />
                        @if ($themeSettings->folder_page->extra_text_section && $themeSettings->folder_page->folder_page_extra_text)
                            <div class="file-card mt-5">
                                {!! $themeSettings->folder_page->folder_page_extra_text !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
@endsection
