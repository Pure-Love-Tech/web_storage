<div class="card mb-3">
    <div class="card-body text-center">
        <form id="changeUserAvatarForm" action="#" method="POST" enctype="multipart/form-data">
            <div class="avatar mb-3">
                <img id="filePreview" src="{{ asset($user->avatar) }}" class="rounded-circle border" width="110px"
                    height="110px">
                <input id="selectedFileInput" data-id="{{ $user->id }}" class="vironeer-user-avatar" type="file"
                    name="avatar" accept="image/png, image/jpg, image/jpeg" hidden>
                <span class="image-error-icon error-icon d-none"><i class="far fa-times-circle"></i></span>
            </div>
        </form>
        <div class="row row-col-1 row-cols-lg-1 row-cols-xxl-2 g-3">
            <div class="col">
                <button id="selectFileBtn" type="button" class="btn btn-secondary w-100"><i
                        class="fas fa-sync-alt me-2"></i>{{ admin_trans('Change') }}</button>
            </div>
            <div class="col">
                <form class="d-inline" action="{{ route('admin.members.users.deleteAvatar', $user->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="vironeer-able-to-delete btn btn-danger w-100"><i
                            class="fas fa-times me-2"></i>{{ admin_trans('Remove') }}</button>
                </form>
            </div>
        </div>
    </div>
    <ul class="custom-list-group list-group list-group-flush border-top">
        <li class="list-group-item d-flex justify-content-between"><span>{{ admin_trans('Username') }} :</span>
            <strong>{{ $user->username }}</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between"><span>{{ admin_trans('Email ') }} :</span>
            <strong>{{ $user->email }}</strong>
        </li>
        @if ($user->referrer)
            <li class="list-group-item d-flex justify-content-between"><span>{{ admin_trans('Referred by') }} :</span>
                <strong>
                    <a href="{{ route('admin.members.users.edit', $user->referrer->referring_user->id) }}"
                        class="text-dark">{{ $user->referrer->referring_user->username }}</a>
                </strong>
            </li>
        @endif
        <li class="list-group-item d-flex justify-content-between"><span>{{ admin_trans('Joined at') }} :</span>
            <strong>{{ dateFormat($user->created_at) }}</strong>
        </li>
    </ul>
</div>
<div class="card mb-3">
    <div class="custom-list-group list-group list-group-flush">
        <a href="{{ route('admin.members.users.edit', $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between {{ request()->routeIs('admin.members.users.edit') ? 'active' : '' }}">
            <span><i class="fa fa-edit me-2"></i>{{ admin_trans('Account details') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.earnings.statistics.index', 'user=' . $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between">
            <span><i class="fa-solid fa-chart-simple me-2"></i>{{ admin_trans('Earnings Statistics') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.earnings.records.index', 'user=' . $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between">
            <span><i class="fa-solid fa-arrows-rotate me-2"></i>{{ admin_trans('Earnings Records') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.withdrawals.index', 'user=' . $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between">
            <span><i class="fa-regular fa-paper-plane me-2"></i>{{ admin_trans('Withdrawals') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.files.users.index', 'user=' . $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between">
            <span> <i class="fa-solid fa-upload me-2"></i>{{ admin_trans('Uploads') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        @if (licenseType(2))
            @if ($user->isSubscribed())
                <a href="{{ route('admin.premium.subscriptions.edit', $user->subscription->id) }}"
                    class="list-group-item list-group-item-action d-flex justify-content-between">
                    <span><i class="fas fa-gem me-2"></i>{{ admin_trans('Subscription') }}</span>
                    <span><i class="fas fa-angle-right"></i></span>
                </a>
            @endif
            <a href="{{ route('admin.premium.transactions.index', 'user=' . $user->id) }}"
                class="list-group-item list-group-item-action d-flex justify-content-between">
                <span><i class="fa-solid fa-file-invoice me-2"></i>{{ admin_trans('Transactions') }}</span>
                <span><i class="fas fa-angle-right"></i></span>
            </a>
        @endif
        <a href="{{ route('admin.members.users.referrals.index', $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between {{ request()->routeIs('admin.members.users.referrals.index') ? 'active' : '' }}">
            <span><i class="fas fa-users me-2"></i>{{ admin_trans('Referrals') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.members.users.logs', $user->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between {{ request()->routeIs('admin.members.users.logs') ? 'active' : '' }}">
            <span><i class="fas fa-list-ul me-2"></i>{{ admin_trans('Login logs') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
    </div>
</div>
