@extends('themes.basic.user.layouts.app')
@section('title', translate('Settings', 'settings'))
@section('content')
    @include('themes.basic.user.settings.includes.links')
    <div class="card-v">
        <h5 class="mb-0">{{ translate('Account details', 'settings') }}</h5>
        <form id="deatilsForm" action="{{ route('user.settings.details.update') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="form-section">
                <div class="row g-4 align-items-center">
                    <div class="col-auto">
                        <div class="settings-user-img">
                            <img id="preview-img-1" src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                            <input id="image-targeted-input-1" type="file" name="avatar"
                                accept="image/png, image/jpg, image/jpeg" hidden>
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-light radius radius-md select-image-button" data-id="1"><i
                                class="fa fa-camera me-2"></i>{{ translate('Choose Avatar', 'settings') }}</button>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <label class="form-label">{{ translate('First Name', 'forms') }} : <span
                                class="required">*</span></label>
                        <input type="firstname" name="firstname" class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('First Name', 'forms') }}" maxlength="50"
                            value="{{ $user->firstname }}" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ translate('Last Name', 'forms') }} : <span
                                class="required">*</span></label>
                        <input type="lastname" name="lastname" class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('Last Name', 'forms') }}" maxlength="50"
                            value="{{ $user->lastname }}" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ translate('Username', 'forms') }} : </label>
                        <input class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('Username', 'forms') }}" value="{{ $user->username }}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Email address', 'forms') }} : <span
                                class="required">*</span></label>
                        <input type="email" name="email" class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('Email address', 'forms') }}" value="{{ $user->email }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Phone Number', 'forms') }} : </label>
                        <input type="tel" name="mobile" class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('Phone Number', 'forms') }}" value="{{ $user->mobile }}">
                    </div>
                </div>
            </div>
            <div class="form-section mb-4">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Address line 1', 'forms') }} : </label>
                        <input type="text" name="address_1" class="form-control form-control-md radius radius-md"
                            value="{{ @$user->address->address_1 }}"
                            placeholder="{{ translate('Address line 1', 'forms') }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Address line 2', 'forms') }} : </label>
                        <input type="text" name="address_2" class="form-control form-control-md radius radius-md"
                            placeholder="{{ translate('Address line 2', 'forms') }}"
                            value="{{ @$user->address->address_2 }}">
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('City', 'forms') }} : </label>
                            <input type="text" name="city" class="form-control form-control-md radius radius-md"
                                value="{{ @$user->address->city }}" placeholder="{{ translate('City', 'forms') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('State', 'forms') }} : </label>
                            <input type="text" name="state" class="form-control form-control-md radius radius-md"
                                value="{{ @$user->address->state }}" placeholder="{{ translate('State', 'forms') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Postal code', 'forms') }} : </label>
                            <input type="text" name="zip" class="form-control form-control-md radius radius-md"
                                value="{{ @$user->address->zip }}"
                                placeholder="{{ translate('Postal code', 'forms') }}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Country', 'forms') }} : </label>
                        <select name="country" class="form-select form-select-md radius radius-md">
                            <option value="">--</option>
                            @foreach (countries() as $country)
                                <option value="{{ $country->id }}"
                                    {{ $country->name == @$user->address->country ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md radius radius-md">{{ translate('Save Changes', 'settings') }}</button>
        </form>
    </div>
@endsection
