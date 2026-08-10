@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Plans') . ' | ' . $plan->name)
@section('back', route('admin.premium.plans.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.plans.update', $plan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">{{ admin_trans('Plan details') }}</div>
            <ul class="custom-list-group list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <label class="col-form-label"><strong>{{ admin_trans('Plan Name') }}</strong></label>
                        </div>
                        <div class="col col-lg-6">
                            <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-lg-6">
                            <label class="col-form-label">
                                <strong>{{ admin_trans('Plan short description') }} :</strong>
                            </label>
                        </div>
                        <div class="col col-lg-6">
                            <textarea name="short_description" class="form-control" placeholder="{{ admin_trans('Optional') }}" rows="2">{{ $plan->short_description }}</textarea>
                        </div>
                    </div>
                </li>
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
        @if ($plan->isPremium())
            <div class="mb-4">
                <button id="add-premium-price" type="button" class="btn btn-success btn-lg">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span>{{ admin_trans('Add Price') }}</span>
                </button>
            </div>
            <div id="premium-plans" class="row row-cols-lg-2 g-3">
                @foreach ($plan->premium_plans as $key => $premium_plan)
                    <div id="premium-price-{{ $key }}" class="col">
                        <div class="card">
                            <div class="card-body p-4">
                                <input type="hidden" name="premium_plans[{{ $key }}][id]"
                                    value="{{ $premium_plan->id }}">
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Interval') }}</label>
                                    <div class="custom-input-group input-group">
                                        <input type="number" name="premium_plans[{{ $key }}][interval]"
                                            class="form-control" placeholder="0" min="1" max="3650"
                                            value="{{ $premium_plan->interval }}" required />
                                        <span class="input-group-text"><strong><i
                                                    class="fas fa-calendar-alt me-2"></i>{{ admin_trans('Days') }}</strong></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ admin_trans('Price') }}</label>
                                    <div class="custom-input-group input-group">
                                        <input id="plan_price_input" type="text"
                                            name="premium_plans[{{ $key }}][price]"
                                            class="form-control plan-input-price" placeholder="0.00" required
                                            value="{{ $premium_plan->price }}" />
                                        <span
                                            class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger remove-premium-price w-100"
                                    data-key="{{ $key }}" data-id="{{ $premium_plan->id }}">
                                    <i class="fa-regular fa-trash-can me-2"></i>
                                    <span>{{ admin_trans('Remove') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery.priceformat.min.js') }}"></script>
    @endpush
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
        @if ($plan->isPremium())
            <script>
                "use strict";

                function inputPrice() {
                    let planInputPrice = $('.plan-input-price');
                    if (planInputPrice.length) {
                        planInputPrice.priceFormat({
                            prefix: '',
                            thousandsSeparator: '',
                            clearOnEmpty: true
                        });
                    }
                }

                let premiumPlans = $('#premium-plans'),
                    addPremiumPriceButton = $('#add-premium-price'),
                    i = parseInt("{{ $plan->premium_plans->count() }}");
                addPremiumPriceButton.on('click', function() {
                    i++;
                    premiumPlans.append('<div id="premium-price-' + i + '" class="col">' +
                        '<div class="card">' +
                        '<div class="card-body p-4">' +
                        '<div class="mb-3">' +
                        '<label class="form-label">' + "{{ admin_trans('Interval') }}" +
                        '</label>' +
                        '<div class="custom-input-group input-group">' +
                        '<input type="number" name="premium_plans[' + i +
                        '][interval]" class="form-control" placeholder="0" required />' +
                        '<span class="input-group-text"><strong><i class="fas fa-calendar-alt me-2"></i>' +
                        "{{ admin_trans('Days') }}" + '</strong></span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<label class="form-label">' + "{{ admin_trans('Price') }}" +
                        '</label>' +
                        '<div class="custom-input-group input-group">' +
                        ' <input id="plan_price_input" type="text" name="premium_plans[' + i +
                        '][price]" class="form-control plan-input-price" placeholder="0.00" required />' +
                        '<span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>' +
                        '</div>' +
                        '</div>' +
                        '<button type="button" class="btn btn-danger remove-premium-price w-100" data-key="' + i +
                        '">' +
                        ' <i class="fa-regular fa-trash-can me-2"></i>' +
                        '<span>' + "{{ admin_trans('Remove') }}" + '</span>' +
                        '</button>' +
                        '</div>' +
                        '</div>');
                    inputPrice();
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 100);
                });
                $(document).on('click', '.remove-premium-price', function() {
                    i--;
                    var key = $(this).data('key'),
                        id = $(this).data('id');
                    if (id) {
                        let url = config.url + '/premium/plans/' + id;
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'JSON',
                            success: function(response) {
                                if ($.isEmptyObject(response.error)) {
                                    $('#premium-price-' + key).remove();
                                } else {
                                    toastr.error(response.error);
                                }
                            },
                        });
                    } else {
                        $('#premium-price-' + key).remove();
                    }
                });
            </script>
        @endif
    @endpush
@endsection
