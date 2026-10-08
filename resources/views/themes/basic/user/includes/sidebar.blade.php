<aside class="dash-sidebar">
    <div class="overlay"></div>
    <div class="dash-sidebar-content">
        <div class="dash-sidebar-body">
            <div class="dash-balance flex-shrink-0">
                <div class="dash-balance-info">
                    <p class="dash-balance-title">{{ translate('Balance', 'sidebar') }}</p>
                    <p class="dash-balance-number mb-0">{{ earnings(auth()->user()->balance()) }}</p>
                </div>
                <div class="dash-balance-icon">
                    <i class="fa fa-wallet"></i>
                </div>
            </div>
            <div class="dash-sidebar-links flex-shrink-0">
                <div class="dash-sidebar-links-body">
                    <a href="javascript:void(0)" class="dash-sidebar-link" data-upload-btn>
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>{{ translate('Upload Files', 'sidebar') }}</span>
                        </div>
                    </a>
                    <a href="{{ route('user.dashboard') }}"
                        class="dash-sidebar-link {{ request()->routeIs('user.dashboard') ? 'current' : '' }}">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-table-columns"></i>
                            <span>{{ translate('Dashboard', 'dashboard') }}</span>
                        </div>
                    </a>
                    <a href="{{ route('user.files.index') }}"
                        class="dash-sidebar-link {{ request()->routeIs('user.files.*') ? 'current' : '' }}">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-folder-open"></i>
                            <span>{{ translate('My Files', 'files') }}</span>
                        </div>
                    </a>
                    <a href="{{ route('user.withdrawals.index') }}"
                        class="dash-sidebar-link {{ request()->routeIs('user.withdrawals.index') ? 'current' : '' }}">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                            <span>{{ translate('Withdrawals', 'withdrawals') }}</span>
                        </div>
                    </a>
                    <a href="{{ route('user.referrals') }}"
                        class="dash-sidebar-link {{ request()->routeIs('user.referrals') ? 'current' : '' }}">
                        <div class="dash-sidebar-link-title">
                            <i class="fa-solid fa-users"></i>
                            <span>{{ translate('Referrals', 'referrals') }}</span>
                        </div>
                    </a>
                    <a href="{{ route('user.settings.index') }}"
                        class="dash-sidebar-link {{ request()->routeIs('user.settings.*') ? 'current' : '' }}">
                        <div class="dash-sidebar-link-title">
                            <i class="fa fa-cog"></i>
                            <span>{{ translate('Settings', 'settings') }}</span>
                        </div>
                    </a>
                    <a href="#" class="dash-sidebar-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="dash-sidebar-link-title">
                            <i class="fas fa-power-off"></i>
                            <span>{{ translate('Logout', 'auth') }}</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="upgrade mt-auto flex-shrink-0">
                <h6 class="upgrade-title">{{ translate('Storage', 'sidebar') }}</h6>
                @if (subscription()->plan->storage_space)
                    <div class="progress mb-2">
                        <div class="progress-bar {{ subscription()->storage->fullness >= 80 && subscription()->storage->fullness < 99 ? 'bg-warning' : (subscription()->storage->fullness == 100 ? 'bg-danger' : 'bg-secondary') }}"
                            role="progressbar" style="width: {{ subscription()->storage->fullness }}%"
                            aria-valuenow="{{ subscription()->storage->fullness }}" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                @endif
                <div class="row g-3 row-cols-auto align-items-center justify-content-between">
                    <div class="col">
                        <h6 class="text-end mb-0 small">
                            {!! str_replace(
                                ['{used_space}', '{storage_space}'],
                                [subscription()->storage->used->formatted, subscription()->formats->storage_space],
                                translate('{used_space} of {storage_space}', 'sidebar'),
                            ) !!}
                        </h6>
                    </div>
                    <div class="col-12">
                        @if (licenseType(2))
                            @if (subscription()->is_premium)
                                @if (subscription()->is_expired)
                                    <a href="{{ route('premium.index') }}"
                                        class="btn btn-outline-secondary radius radius-md w-100">
                                        <i class="fa-solid fa-rotate me-1"></i>
                                        {{ translate('Renew', 'sidebar') }}
                                    </a>
                                @else
                                    <button class="btn btn-primary radius radius-md w-100" data-upload-btn>
                                        <i class="fa fa-upload me-1"></i>
                                        {{ translate('Upload files', 'sidebar') }}
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('premium.index') }}" class="btn btn-primary radius radius-md w-100">
                                    <i class="fa fa-gem me-1"></i>
                                    {{ translate('Upgrade', 'sidebar') }}
                                </a>
                            @endif
                        @else
                            <button class="btn btn-primary radius radius-md w-100" data-upload-btn>
                                <i class="fa fa-upload me-1"></i>
                                {{ translate('Upload files', 'sidebar') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
