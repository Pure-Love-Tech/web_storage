@extends('backend.layouts.grid')
@section('container', 'container-max-lg')
@section('title', admin_trans('System Information'))
@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white border-bottom-0"><i
                class="fas fa-folder me-2"></i>{{ admin_trans('Application') }}</div>
        <ul class="custom-list-group system list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>{{ admin_trans('Name') }}</strong>
                <span class="capitalize">{{ str_replace('_', ' ', $system->application->name) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                <strong>{{ admin_trans('Version') }}</strong>
                <span>v{{ $system->application->version }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center ">
                <strong>{{ admin_trans('Laravel Version') }}</strong>
                <span>v{{ $system->application->laravel }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                <strong>{{ admin_trans('Timezone') }}</strong>
                <span class="capitalize">{{ $system->application->timezone }}</span>
            </li>
        </ul>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-lg-5 text-white border-bottom-0"><i
                class="fas fa-server me-2"></i>{{ admin_trans('Server Details') }}</div>
        <ul class="custom-list-group system list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>{{ admin_trans('Software') }}</strong>
                <span>{{ $system->server->SERVER_SOFTWARE }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                <strong>{{ admin_trans('PHP Version') }}</strong>
                <span>v{{ $system->server->php }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>{{ admin_trans('IP Address') }}</strong>
                <span>{{ $system->server->SERVER_ADDR }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                <strong>{{ admin_trans('Protocol') }}</strong>
                <span>{{ $system->server->SERVER_PROTOCOL }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>{{ admin_trans('HTTP Host') }}</strong>
                <span>{{ $system->server->HTTP_HOST }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                <strong>{{ admin_trans('Port') }}</strong>
                <span>{{ $system->server->SERVER_PORT }}</span>
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header bg-lg-5 text-white border-bottom-0"><i
                class="fas fa-database me-2"></i>{{ admin_trans('System Cache') }}</div>
        <ul class="custom-list-group system list-group list-group-flush">
            <li class="list-group-item">
                <i class="far fa-check-circle me-2 text-success"></i>
                <span>{{ admin_trans('Compiled views will be cleared') }}</span>
            </li>
            <li class="list-group-item">
                <i class="far fa-check-circle me-2 text-success"></i>
                <span>{{ admin_trans('Application cache will be cleared') }}</span>
            </li>
            <li class="list-group-item">
                <i class="far fa-check-circle me-2 text-success"></i>
                <span>{{ admin_trans('Route cache will be cleared') }}</span>
            </li>
            <li class="list-group-item">
                <i class="far fa-check-circle me-2 text-success"></i>
                <span>{{ admin_trans('Configuration cache will be cleared') }}</span>
            </li>
            <li class="list-group-item">
                <i class="far fa-check-circle me-2 text-success"></i>
                <span>{{ admin_trans('All Other Caches will be cleared') }}</span>
            </li>
            <li class="list-group-item">
                <i class="far fa-check-circle me-2 text-success"></i>
                <span>{{ admin_trans('Error logs file will be cleared') }}</span>
            </li>
            <li class="list-group-item p-0"></li>
        </ul>
        <div class="card-body">
            <a href="{{ route('admin.system.info.cache') }}" class="btn btn-primary btn-lg w-100 vironeer-link-confirm"><i
                    class="far fa-trash-alt me-2"></i>{{ admin_trans('Clear System Cache') }}</a>
        </div>
    </div>
@endsection
