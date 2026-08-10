@extends('backend.layouts.grid')
@section('section', admin_trans('Users'))
@section('title', admin_trans('Login Logs for ' . request()->ip))
@section('back', route('admin.members.users.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            @if (!demoMode())
                @forelse ($logs as $log)
                    <div class="logs-box justify-items-center">
                        <div class="content ms-1 d-flex justify-content-between">
                            <span>
                                <h5>
                                    <a href="{{ route('admin.members.users.logsbyip', $log->ip) }}">{{ $log->ip }}</a>
                                </h5>
                                <p class="text-muted capitalize"><i
                                        class="fas fa-map-marker-alt me-2"></i>{{ $log->location }}
                                    <span class="me-1 ms-1">|</span> <i class="fa fa-user me-1"></i> <a
                                        href="{{ route('admin.members.users.edit', $log->user->id) }}">{{ $log->user->username }}</a>
                                </p>
                            </span>
                            <span>
                                <a href="#" data-user="{{ $log->user->id }}" data-log="{{ $log->id }}"
                                    class="vironeer-getlog-btn btn btn-blue btn-sm"><i class="fas fa-desktop"></i></a>
                            </span>
                        </div>
                    </div>
                @empty
                    @include('backend.partials.empty', ['class' => 'empty-lg'])
                @endforelse
            @else
                <span>{{ admin_trans('Hidden in demo') }}</span>
            @endif
        </div>
    </div>
    {{ $logs->links() }}
    @include('backend.includes.logsmodal')
@endsection
