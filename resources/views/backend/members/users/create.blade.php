@extends('backend.layouts.form')
@section('section', admin_trans('Users'))
@section('title', admin_trans('Add new user'))
@section('container', 'container-max-lg')
@section('back', route('admin.members.users.index'))
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            {{ admin_trans('User details') }}
        </div>
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.members.users.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="avatar text-center py-4">
                    <div>
                        <img id="filePreview" src="{{ asset('images/avatars/default.png') }}" class="rounded-circle mb-3"
                            width="110" height="110">
                        <input id="selectedFileInput" type="file" name="avatar"
                            accept="image/png, image/jpg, image/jpeg" hidden>
                    </div>
                    <button id="selectFileBtn" type="button" class="btn btn-secondary"><i
                            class="fas fa-camera me-2"></i>{{ admin_trans('Choose Image') }}</button>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Username') }}</label>
                    <input type="username" name="username" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('E-mail Address') }}</label>
                    <input type="email" name="email" class="form-control form-control-lg" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ admin_trans('Password') }}</label>
                    <input type="text" name="password" class="form-control form-control-lg" required>
                </div>
            </form>
        </div>
    </div>
@endsection
