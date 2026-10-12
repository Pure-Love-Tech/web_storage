@extends('themes.basic.user.layouts.app')
@section('title', translate('My Files', 'files'))
@section('content')
    <livewire:files.files-table />
    <livewire:files.folder-modal />
    <livewire:files.share-modal />
    <livewire:files.edit-modal />
    <livewire:files.move-modal />
    @push('head_codes')
        <livewire:styles />
    @endpush
    @push('scripts')
        <livewire:scripts />
        <script src="{{ theme_asset('assets/js/filemanager.js') }}"></script>
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
