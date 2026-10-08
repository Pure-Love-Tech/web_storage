@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Payment Gateways') . ' | ' . $paymentGateway->name)
@section('container', 'container-max-lg')
@section('back', route('admin.premium.payment-gateways.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.payment-gateways.update', $paymentGateway->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-header">{{ admin_trans('Details') }}</div>
            <div class="card-body">
                <div class="row g-3 mb-2 align-items-center">
                    <div class="col-lg-12">
                        <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                            <div class="file-preview-box mb-3">
                                <img id="filePreview" src="{{ asset($paymentGateway->logo) }}" class="rounded-3"
                                    height="40px" height="40px">
                            </div>
                            <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ admin_trans('Choose Logo') }}</button>
                            <input id="selectedFileInput" type="file" name="logo" accept=".png, .jpg, .jpeg" hidden>
                            <small class="text-muted d-block">{{ admin_trans('Allowed (PNG, JPG, JPEG)') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Name') }}
                        </label>
                        <input type="text" name="name" class="form-control" value="{{ $paymentGateway->name }}"
                            required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Status') }} </label>
                        <input type="checkbox" name="status" data-toggle="toggle"
                            {{ $paymentGateway->status ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
        @if ($paymentGateway->description)
            <div class="card mb-3">
                <div class="card-header">{{ admin_trans('Description') }}</div>
                <div class="card-body">
                    {!! str_replace('[URL]', url('/'), $paymentGateway->description) !!}
                </div>
            </div>
        @endif
        @if (!$paymentGateway->isManual())
            <div class="card">
                <div class="card-header">{{ admin_trans('Credentials') }}</div>
                <div class="card-body">
                    <div class="row mb-2 g-3">
                        @foreach ($paymentGateway->credentials as $key => $value)
                            <div class="col-lg-12">
                                <label class="form-label capitalize">{{ $paymentGateway->name }}
                                    {{ str_replace('_', ' ', $key) }}</label>
                                <input type="text" name="credentials[{{ $key }}]"
                                    value="{{ demoMode() ? '' : $value }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            @if ($paymentGateway->alias != 'balance')
                <div class="card">
                    <div class="card-header">{{ admin_trans('Instructions') }}</div>
                    <div class="card-body ckeditor-md">
                        <div class="mb-2">
                            <textarea name="instructions" class="ckeditor">{{ $paymentGateway->instructions }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
    @endpush
@endsection
