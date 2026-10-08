@extends('backend.layouts.form')
@section('section', admin_trans('Settings'))
@section('title', admin_trans('Plans') . ' | ' . $plan->name)
@section('back', route('admin.plans.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">{{ admin_trans('Plan details') }}</div>
            <ul class="custom-list-group list-group list-group-flush">
                @if ($plan->isForVisitors())
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-8 col-lg-8">
                                <label class="col-form-label"><strong>{{ admin_trans('Upload Status') }} :
                                    </strong></label>
                                <div><small
                                        class="text-muted">{{ admin_trans('Allow or disable uploading of files by visitors') }}</small>
                                </div>
                            </div>
                            <div class="col-4 col-lg-4">
                                <input id="upload_status" type="checkbox" name="upload_status" data-toggle="toggle"
                                    data-on="{{ admin_trans('Active') }}" data-off="{{ admin_trans('Disabled') }}"
                                    {{ $plan->upload_status ? 'checked' : '' }}>
                            </div>
                        </div>
                    </li>
                @endif
                <li
                    class="list-group-item upload-options {{ $plan->isForVisitors() && !$plan->upload_status ? 'd-none' : '' }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <label class="col-form-label"><strong>{{ admin_trans('Storage space') }}</strong></label>
                        </div>
                        <div class="col-12 col-lg-2">
                            <input type="checkbox" name="unlimited_storage_space"
                                class="form-check-input plan-unlimited-checkbox" data-id="1"
                                {{ !$plan->storage_space ? 'checked' : '' }}>
                            <label>{{ admin_trans('Unlimited') }}</label>
                        </div>
                        <div class="col col-lg-4">
                            <div id="plan-unlimited-options-1" class="custom-input-group input-group">
                                <input type="number" name="storage_space" class="form-control" placeholder="0"
                                    value="{{ $plan->storage_space }}" required
                                    {{ !$plan->storage_space ? 'disabled' : '' }}>
                                <span class="input-group-text  {{ !$plan->storage_space ? 'disabled' : '' }}"><strong><i
                                            class="fas fa-hdd me-2"></i>{{ admin_trans('MB') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li
                    class="list-group-item upload-options {{ $plan->isForVisitors() && !$plan->upload_status ? 'd-none' : '' }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <label class="col-form-label"><strong>{{ admin_trans('Max file size') }}</strong></label>
                            <div><small
                                    class="text-muted">{{ admin_trans('The maximum size per each file uploaded') }}</small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <input type="checkbox" name="unlimited_max_file_size"
                                class="form-check-input plan-unlimited-checkbox" data-id="2"
                                {{ !$plan->max_file_size ? 'checked' : '' }}>
                            <label>{{ admin_trans('Unlimited') }}</label>
                        </div>
                        <div class="col col-lg-4">
                            <div id="plan-unlimited-options-2" class="custom-input-group input-group">
                                <input type="number" name="max_file_size" class="form-control" placeholder="0"
                                    value="{{ $plan->max_file_size }}" required
                                    {{ !$plan->max_file_size ? 'disabled' : '' }}>
                                <span class="input-group-text {{ !$plan->max_file_size ? 'disabled' : '' }}"><strong><i
                                            class="fas fa-hdd me-2"></i>{{ admin_trans('MB') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li
                    class="list-group-item upload-options {{ $plan->isForVisitors() && !$plan->upload_status ? 'd-none' : '' }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <label class="col-form-label"><strong>{{ admin_trans('File expiry days') }}
                                </strong></label>
                            <div><small class="text-muted">{{ admin_trans('Starts from the last download') }}</small></div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <input type="checkbox" name="unlimited_file_expiry_days"
                                class="form-check-input plan-unlimited-checkbox" data-id="3"
                                {{ !$plan->file_expiry_days ? 'checked' : '' }}>
                            <label>{{ admin_trans('Unlimited') }}</label>
                        </div>
                        <div class="col col-lg-4">
                            <div id="plan-unlimited-options-3" class="custom-input-group input-group">
                                <input type="number" name="file_expiry_days" class="form-control"
                                    value="{{ $plan->file_expiry_days }}" placeholder="0"
                                    {{ !$plan->file_expiry_days ? 'disabled' : '' }} min="1" max="3650"
                                    required />
                                <span class="input-group-text {{ !$plan->file_expiry_days ? 'disabled' : '' }}"><strong><i
                                            class="fas fa-calendar-alt me-2"></i>{{ admin_trans('Days') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <label
                                class="col-form-label"><strong>{{ admin_trans('Download waiting time') }}</strong></label>
                            <div><small
                                    class="text-muted">{{ admin_trans('The counter time on the third download page') }}</small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <input type="checkbox" name="disable_download_waiting_time"
                                class="form-check-input plan-unlimited-checkbox" data-id="4"
                                {{ !$plan->download_waiting_time ? 'checked' : '' }}>
                            <label>{{ admin_trans('Disable') }}</label>
                        </div>
                        <div class="col col-lg-4">
                            <div id="plan-unlimited-options-4" class="custom-input-group input-group">
                                <input type="number" name="download_waiting_time" class="form-control" placeholder="0"
                                    min="1" max="1000" value="{{ $plan->download_waiting_time }}" required
                                    {{ !$plan->download_waiting_time ? 'disabled' : '' }}>
                                <span
                                    class="input-group-text {{ !$plan->download_waiting_time ? 'disabled' : '' }}"><strong><i
                                            class="far fa-clock me-2"></i>{{ admin_trans('Seconds') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-8 col-lg-8">
                            <label class="col-form-label"><strong>{{ admin_trans('Advertisements') }} :
                                </strong></label>
                        </div>
                        <div class="col-4 col-lg-4">
                            <input type="checkbox" name="advertisements" data-toggle="toggle"
                                data-on="{{ admin_trans('Visible') }}" data-off="{{ admin_trans('Hidden') }}"
                                {{ $plan->advertisements ? 'checked' : '' }}>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-8 col-lg-8">
                            <label class="col-form-label"><strong>{{ admin_trans('Download Captcha') }} :
                                </strong></label>
                        </div>
                        <div class="col-4 col-lg-4">
                            <input type="checkbox" name="download_captcha" data-toggle="toggle"
                                data-on="{{ admin_trans('Visible') }}" data-off="{{ admin_trans('Hidden') }}"
                                {{ $plan->download_captcha ? 'checked' : '' }}>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
    @push('scripts')
        <script>
            "use strict";
            let uploadStatus = $('#upload_status'),
                uploadOptions = $('.upload-options');
            uploadStatus.on('change', function() {
                if ($(this).prop('checked') == true) {
                    uploadOptions.each(function(i, obj) {
                        $(obj).removeClass('d-none');
                    });
                } else {
                    uploadOptions.each(function(i, obj) {
                        $(obj).addClass('d-none');
                    });
                }
            });
            let planUnlimitedCheckbox = $('.plan-unlimited-checkbox');
            planUnlimitedCheckbox.on('change', function() {
                var id = $(this).data('id'),
                    input = $('#plan-unlimited-options-' + id + ' input'),
                    span = $('#plan-unlimited-options-' + id + ' span');
                if ($(this).prop('checked') == true) {
                    input.prop('disabled', true);
                    span.addClass('disabled');
                } else {
                    input.prop('disabled', false);
                    span.removeClass('disabled');
                }
            });
        </script>
    @endpush
@endsection
