@extends('backend.layouts.form')
@section('title', admin_trans('Edit | ') . $extension->name)
@section('section', admin_trans('Settings'))
@section('back', route('admin.settings.extensions.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.extensions.update', $extension->id) }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="vironeer-file-preview-box bg-light mb-3 p-4 text-center">
                    <div class="file-preview-box mb-3">
                        <img id="filePreview" src="{{ asset($extension->logo) }}" height="100px" height="100px">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Name') }} </label>
                        <input class="form-control" value="{{ $extension->name }}" readonly>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label">{{ admin_trans('Status') }}</label>
                        <input type="checkbox" name="status" data-toggle="toggle"
                            @if ($extension->status) checked @endif>
                    </div>
                </div>
            </div>
        </div>
        @if ($extension->instructions)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="far fa-question-circle me-2"></i>{{ $extension->name . admin_trans(' Instructions') }}
                </div>
                <div class="card-body">
                    {!! str_replace('[URL]', url('/'), $extension->instructions) !!}
                </div>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-key me-2"></i> {{ $extension->name . admin_trans(' Credentials') }}
            </div>
            <div class="card-body">
                <div class="row g-3 pb-2">
                    @foreach ($extension->credentials as $key => $value)
                        <div class="col-lg-12">
                            <label class="form-label capitalize">{{ $extension->name }}
                                {{ str_replace('_', ' ', $key) }} :
                            </label>
                            <input type="text" name="credentials[{{ $key }}]"
                                value="{{ demoMode() ? '' : $value }}" class="form-control remove-spaces">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection
