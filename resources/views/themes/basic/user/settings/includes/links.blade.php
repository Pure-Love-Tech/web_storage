<div class="settings-links mb-4">
    <div class="row row-cols-1 row-cols-sm-auto g-2">
        <div class="col">
            <a href="{{ route('user.settings.index') }}"
                class="settings-link {{ request()->routeIs('user.settings.index') ? 'active' : '' }}">
                <i class="fa fa-user me-1"></i>
                {{ translate('Account details', 'settings') }}
            </a>
        </div>
        <div class="col">
            <a href="{{ route('user.settings.password') }}"
                class="settings-link {{ request()->routeIs('user.settings.password') ? 'active' : '' }}">
                <i class="fa-solid fa-lock me-1"></i>
                {{ translate('Change Password', 'settings') }}
            </a>
        </div>
        <div class="col">
            <a href="{{ route('user.settings.2fa') }}"
                class="settings-link {{ request()->routeIs('user.settings.2fa') ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved me-1"></i>
                {{ translate('2FA Authentication', 'settings') }}
            </a>
        </div>
        <div class="col">
            <a href="{{ route('user.settings.withdrawal') }}"
                class="settings-link {{ request()->routeIs('user.settings.withdrawal') ? 'active' : '' }}">
                <i class="fa-solid fa-landmark me-1"></i>
                {{ translate('Withdrawal details', 'settings') }}
            </a>
        </div>
        @if (licenseType(2))
            <div class="col">
                <a href="{{ route('user.settings.subscription') }}"
                    class="settings-link {{ request()->routeIs('user.settings.subscription') ? 'active' : '' }}">
                    <i class="fa-solid fa-gem me-1"></i>
                    {{ translate('Subscription', 'settings') }}
                </a>
            </div>
        @endif
    </div>
</div>
