<div class="drop-down user-menu ms-3" data-dropdown data-dropdown-position="top">
    <div class="drop-down-btn">
        <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="user-img">
        <span class="user-name">{{ auth()->user()->name }}</span>
        <i class="fa fa-angle-down ms-2"></i>
    </div>
    <div class="drop-down-menu">
        @if (!request()->routeIs('verification.verify') && !request()->routeIs('2fa.verify'))
            <a href="{{ route('user.dashboard') }}" class="drop-down-item">
                <i class="fa-solid fa-table-columns"></i>
                <span>{{ translate('Dashboard', 'dashboard') }}</span>
            </a>
            <a href="{{ route('user.files.index') }}" class="drop-down-item">
                <i class="fa-regular fa-folder-open"></i>
                <span>{{ translate('My Files', 'files') }}</span>
            </a>
            <a href="{{ route('user.settings.index') }}" class="drop-down-item">
                <i class="fa fa-cog"></i>
                <span>{{ translate('Settings', 'settings') }}</span>
            </a>
        @endif
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="drop-down-item text-danger">
            <i class="fa fa-power-off"></i>
            <span>{{ translate('Logout', 'auth') }}</span>
        </a>
    </div>
</div>
<form id="logout-form" class="d-inline" action="{{ route('logout') }}" method="POST">
    @csrf
</form>
