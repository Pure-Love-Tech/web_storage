@extends('backend.layouts.form')
@section('title', admin_trans('Mail Templates') . ' | ' . $mailTemplate->name)
@section('section', admin_trans('Settings'))
@section('back', route('admin.settings.mailtemplates.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.mailtemplates.update', $mailTemplate->id) }}"
        method="POST">
        @csrf
        <div class="card">
            <div class="card-header bg-lg-3 text-white">{{ admin_trans('Template') }}</div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="{{ $mailTemplate->nonDisabled() ? 'col-lg-12' : 'col-lg-8' }}">
                        <label class="form-label">{{ admin_trans('Subject') }}</label>
                        <input type="text" name="subject" class="form-control" value="{{ $mailTemplate->subject }}"
                            required>
                    </div>
                    @if (!$mailTemplate->nonDisabled())
                        <div class="col-lg-4">
                            <label class="form-label">{{ admin_trans('Status') }}</label>
                            <input type="checkbox" name="status" data-toggle="toggle"
                                {{ $mailTemplate->status ? 'checked' : '' }}>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Body') }}</label>
                    <textarea name="body" class="ckeditor">{{ $mailTemplate->body }}</textarea>
                </div>
                <div class="alert alert-secondary mb-0">
                    <p class="mb-0"><strong>{{ admin_trans('Short Codes') }}</strong></p>
                    @foreach ($mailTemplate->shortcodes as $key => $value)
                        <li class="mt-2"><strong>@php echo "{{ ". $key ." }}"  @endphp</strong> : {{ $value }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
    @endpush
@endsection
