@extends('backend.layouts.form')
@section('section', admin_trans('Premium'))
@section('title', admin_trans('Plans'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.plans.sort') }}" method="POST">
        @csrf
        <input type="hidden" name="ids" id="ids" value="{{ $idsArray }}">
    </form>
    <div class="card mb-3">
        <ul class="vironeer-sort-menu custom-list-group list-group list-group-flush">
            @foreach ($plans as $plan)
                <li data-id="{{ $plan->id }}" class="list-group-item d-flex justify-content-between align-items-center">
                    <h5 class="m-0">
                        <span class="vironeer-navigation-handle me-2 text-muted"><i class="fas fa-arrows-alt"></i></span>
                        <span>
                            <a href="{{ route('admin.premium.plans.edit', $plan->id) }}" class="text-dark">
                                <span>{{ $plan->name }}</span>
                                @if ($plan->isPremium())
                                    <i class="fa-solid fa-crown text-warning"></i>
                                @endif

                            </a>
                        </span>
                    </h5>
                    <div class="buttons">
                        @if ($plan->isForVisitors() && !$plan->upload_status)
                            <span class="badge bg-danger me-3">{{ admin_trans('Upload disabled') }}</span>
                        @endif
                        <a class="btn btn-blue btn-sm me-2" href="{{ route('admin.premium.plans.edit', $plan->id) }}"><i
                                class="fa fa-edit me-2"></i>{{ admin_trans('Edit') }}</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @push('styles_libs')
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
