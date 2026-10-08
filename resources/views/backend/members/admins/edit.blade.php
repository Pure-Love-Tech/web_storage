@extends('backend.layouts.form')
@section('title', 'Admin | ' . $admin->firstname . ' ' . $admin->lastname)
@section('section', admin_trans('Settings'))
@section('container', 'container-max-lg')
@section('back', route('admin.members.admins.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.members.admins.update', $admin->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card p-2">
            <div class="card-body">
                <div class="avatar text-center py-4">
                    <img id="filePreview" src="{{ asset($admin->avatar) }}" class="rounded-circle mb-3" width="120px"
                        height="120px">
                    <button id="selectFileBtn" type="button"
                        class="btn btn-secondary d-flex m-auto">{{ admin_trans('Choose Image') }}</button>
                    <input id="selectedFileInput" type="file" name="avatar" accept="image/png, image/jpg, image/jpeg"
                        hidden>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('First Name') }}</label>
                            <input type="firstname" class="form-control" name="firstname" value="{{ $admin->firstname }}"
                                required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ admin_trans('Last Name') }}</label>
                            <input type="lastname" class="form-control" name="lastname" value="{{ $admin->lastname }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Email Address') }}</label>
                    <input type="email" class="form-control" name="email" value="{{ $admin->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('New Password') }} </label>
                    <input type="text" class="form-control" name="password">
                    <small
                        class="text-muted">{{ admin_trans("Leave it empty if you don't want to change password") }}</small>
                </div>
            </div>
        </div>
    </form>
@endsection
