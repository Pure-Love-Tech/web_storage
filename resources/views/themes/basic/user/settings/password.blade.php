@extends('themes.basic.user.layouts.app')
@section('title', translate('Settings', 'settings'))
@section('content')
    @include('themes.basic.user.settings.includes.links')
    <div class="card-v">
        <h5 class="mb-0">{{ translate('Change Password', 'settings') }}</h5>
        <div class="form-section">
            <form id="deatilsForm" action="{{ route('user.settings.password.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ translate('Password', 'forms') }} : <span class="required">*</span></label>
                    <input type="password" class="form-control form-control-md radius radius-md" name="current-password"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('New Password', 'forms') }} : <span
                            class="required">*</span></label>
                    <input type="password" class="form-control form-control-md radius radius-md" name="new-password"
                        required>
                </div>
                <div class="mb-4">
                    <label class="form-label">{{ translate('Confirm New Password', 'forms') }} : <span
                            class="required">*</span></label>
                    <input type="password" class="form-control form-control-md radius radius-md"
                        name="new-password_confirmation" required>
                </div>
                <button class="btn btn-primary btn-md radius radius-md">{{ translate('Save Changes', 'settings') }}</button>
            </form>
        </div>
    </div>
@endsection
