@extends('backend.layouts.grid')
@section('title', admin_trans('Report') . ' | #' . $fileReport->id)
@section('back', route('admin.files.reports.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card mb-2">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                @php
                    $fileEntry = $fileReport->file_entry;
                    $link = route($fileEntry->user_id ? 'admin.files.users.show' : 'admin.files.visitors.show', $fileEntry->id);
                @endphp
                <div class="flex-shrink-0">
                    <a href="{{ $link }}" target="_blank">
                        {!! $fileEntry->getFileIcon() !!}
                    </a>
                </div>
                <div class="flex-grow-1 ms-3">
                    <a href="{{ $link }}" target="_blank" class="text-dark">
                        <h5 class="mb-1">
                            {{ shortertext($fileEntry->getFullName(), 50) }}
                        </h5>
                        <p class="mb-0 text-muted">
                            {{ shortertext($fileEntry->mime, 50) ?? admin_trans('Unknown') }}
                        </p>
                    </a>
                </div>
                <div class="flex-grow-3 ms-3">
                    <a href="{{ $link }}" target="_blank" class="btn btn-primary" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>
                        {{ admin_trans('View file details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <label class="form-label">{{ admin_trans('Name') }}</label>
                    <input type="name" class="form-control form-control-lg" value="{{ $fileReport->name }}" readonly>
                </div>
                <div class="col-lg-6">
                    <label class="form-label">{{ admin_trans('Email') }}</label>
                    <input type="email" class="form-control form-control-lg" value="{{ $fileReport->email }}" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ admin_trans('Reason for reporting') }}</label>
                <input type="email" class="form-control form-control-lg"
                    value="{{ \App\Models\FileReport::reasons()[$fileReport->reason] }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ admin_trans('Details') }}</label>
                <textarea class="form-control" rows="8" readonly>{{ $fileReport->details }}</textarea>
            </div>
            <form action="{{ route('admin.files.reports.destroy', $fileReport->id) }}" method="POST">
                @csrf @method('DELETE')
                <button class="vironeer-able-to-delete btn btn-danger btn-lg w-100"><i
                        class="far fa-trash-alt me-2"></i>{{ admin_trans('Delete') }}</button>
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/vironeer-icons.min.css') }}">
    @endpush
@endsection
