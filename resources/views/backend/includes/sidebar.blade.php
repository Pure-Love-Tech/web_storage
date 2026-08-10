<aside class="vironeer-sidebar">
    <div class="overlay"></div>
    <div class="vironeer-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="vironeer-sidebar-logo">
            <img src="{{ asset($themeSettings->general->logo_light) }}" alt="{{ $settings->general->site_name }}" />
        </a>
    </div>
    <div class="vironeer-sidebar-menu" data-simplebar>
        <div class="vironeer-sidebar-links">
            <div class="vironeer-sidebar-links-cont">
                <a href="{{ route('admin.dashboard') }}"
                    class="vironeer-sidebar-link {{ request()->segment(2) == 'dashboard' ? 'current' : '' }}">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-table-columns"></i>{{ admin_trans('Dashboard') }}</span>
                    </p>
                </a>
                <div class="vironeer-sidebar-link  {{ request()->segment(2) == 'members' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span class="w-100">
                            <span><i class="fas fa-users"></i>{{ admin_trans('Members') }}</span>
                        </span>
                        @if ($sidebar_counters['users'])
                            <span class="counter me-2">{{ $sidebar_counters['users'] }}</span>
                        @endif
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.members.users.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'users' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('Users') }}</span>
                                @if ($sidebar_counters['users'])
                                    <span class="counter">{{ $sidebar_counters['users'] }}</span>
                                @endif
                            </p>
                        </a>
                        <a href="{{ route('admin.members.admins.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'admins' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Admins') }}</span></p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'files' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span class="w-100">
                            <i class="fa-regular fa-folder-open"></i>{{ admin_trans('Manage Files') }}
                        </span>
                        @if ($sidebar_counters['users_files'] || $sidebar_counters['visitors_files'] || $sidebar_counters['reported_files'])
                            <span
                                class="counter me-2">{{ $sidebar_counters['users_files'] + $sidebar_counters['visitors_files'] + $sidebar_counters['reported_files'] }}</span>
                        @endif
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.files.users.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'users' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('Users Files') }}</span>
                                @if ($sidebar_counters['users_files'])
                                    <span class="counter">{{ $sidebar_counters['users_files'] }}</span>
                                @endif
                            </p>
                        </a>
                        <a href="{{ route('admin.files.visitors.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'visitors' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('Visitors Files') }}</span>
                                @if ($sidebar_counters['visitors_files'])
                                    <span class="counter">{{ $sidebar_counters['visitors_files'] }}</span>
                                @endif
                            </p>
                        </a>
                        <a href="{{ route('admin.files.reports.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'reports' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('Reported Files') }}</span>
                                @if ($sidebar_counters['reported_files'])
                                    <span class="counter">{{ $sidebar_counters['reported_files'] }}</span>
                                @endif
                            </p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-links-cont">
                    <div class="vironeer-sidebar-link {{ request()->segment(2) == 'earnings' ? 'active' : '' }}"
                        data-dropdown>
                        <p class="vironeer-sidebar-link-title">
                            <span><i class="fa-solid fa-dollar-sign"></i>{{ admin_trans('Earnings') }}</span>
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="vironeer-sidebar-link-menu">
                            <a href="{{ route('admin.earnings.settings') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'settings' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Settings') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.earnings.statistics.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'statistics' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Statistics') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.earnings.records.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'records' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Records') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.earnings.reports.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'reports' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Reports') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.earnings.payout-rates.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'payout-rates' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Payout Rates') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.earnings.withdrawal-methods.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'withdrawal-methods' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title">
                                    <span>{{ admin_trans('Withdrawal Methods') }}</span>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.withdrawals.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'withdrawals') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-money-bill-transfer"></i>{{ admin_trans('Withdrawals') }}</span>
                        @if ($sidebar_counters['withdrawals'])
                            <span class="counter">{{ $sidebar_counters['withdrawals'] }}</span>
                        @endif
                    </p>
                </a>
                <a href="{{ route('admin.announcements.index') }}"
                    class="vironeer-sidebar-link {{ request()->segment(2) == 'announcements' ? 'current' : '' }}">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-bullhorn"></i>{{ admin_trans('Announcements') }}</span>
                    </p>
                </a>
                @if (licenseType(1))
                    <a href="{{ route('admin.plans.index') }}"
                        class="vironeer-sidebar-link {{ request()->segment(2) == 'plans' ? 'current' : '' }}">
                        <p class="vironeer-sidebar-link-title">
                            <span><i class="fa-solid fa-cubes"></i>{{ admin_trans('Manage Plans') }}</span>
                        </p>
                    </a>
                @endif
                <a href="{{ route('admin.advertisements.index') }}"
                    class="vironeer-sidebar-link {{ request()->segment(2) == 'advertisements' ? 'current' : '' }}">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-ad"></i>{{ admin_trans('Advertisements') }}</span>
                    </p>
                </a>
            </div>
            @if (licenseType(2))
                <div class="vironeer-sidebar-links-cont">
                    <div class="vironeer-sidebar-link {{ request()->segment(2) == 'premium' ? 'active' : '' }}"
                        data-dropdown>
                        <p class="vironeer-sidebar-link-title">
                            <span class="w-100"><i class="fa-regular fa-gem"></i>{{ admin_trans('Premium') }}</span>
                            @if ($sidebar_counters['subscriptions'] || $sidebar_counters['transactions'])
                                <span
                                    class="counter me-2">{{ $sidebar_counters['subscriptions'] + $sidebar_counters['transactions'] }}</span>
                            @endif
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="vironeer-sidebar-link-menu">
                            <a href="{{ route('admin.premium.settings') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'settings' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Settings') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.premium.plans.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'plans' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Plans') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.premium.subscriptions.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'subscriptions' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Subscriptions') }}</span>
                                    @if ($sidebar_counters['subscriptions'])
                                        <span class="counter">{{ $sidebar_counters['subscriptions'] }}</span>
                                    @endif
                                </p>
                            </a>
                            <a href="{{ route('admin.premium.transactions.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'transactions' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Transactions') }}</span>
                                    @if ($sidebar_counters['transactions'])
                                        <span class="counter">{{ $sidebar_counters['transactions'] }}</span>
                                    @endif
                                </p>
                            </a>
                            <a href="{{ route('admin.premium.payment-gateways.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'payment-gateways' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title">
                                    <span>{{ admin_trans('Payment Gateways') }}</span>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'navigation' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-bars"></i>{{ admin_trans('Navigation') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.navbarMenu.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'navbarMenu' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Navbar Menu') }}</span></p>
                        </a>
                        <a href="{{ route('admin.footerMenu.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'footerMenu' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Footer Menu') }}</span></p>
                        </a>
                    </div>
                </div>
                @if ($settings->actions->blog_status)
                    <div class="vironeer-sidebar-link  {{ request()->segment(2) == 'blog' ? 'active' : '' }}"
                        data-dropdown>
                        <p class="vironeer-sidebar-link-title">
                            <span><i class="fas fa-rss"></i>{{ admin_trans('Blog') }}</span>
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="vironeer-sidebar-link-menu">
                            <a href="{{ route('admin.blog.articles.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'articles' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Articles') }}</span></p>
                            </a>
                            <a href="{{ route('admin.blog.categories.index') }}"
                                class="vironeer-sidebar-link  {{ request()->segment(3) == 'categories' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Categories') }}</span>
                                </p>
                            </a>
                            <a href="{{ route('admin.blog.comments.index') }}"
                                class="vironeer-sidebar-link {{ request()->segment(3) == 'comments' ? 'current' : '' }}">
                                <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Comments') }}</span>
                                    @if ($sidebar_counters['comments'])
                                        <span class="counter">{{ $sidebar_counters['comments'] }}</span>
                                    @endif
                                </p>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'appearance' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-brush"></i>{{ admin_trans('Appearance') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.appearance.themes.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'themes' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('Themes') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'settings' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-cog"></i>{{ admin_trans('Settings') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.settings.general') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'general' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('General Information') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.settings.filesystem') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'filesystem' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('File System') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.settings.oauth-providers.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'oauth-providers' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('OAuth Providers') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.settings.storage.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'storage' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('Storage Providers') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.settings.smtp.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'smtp' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('SMTP Information') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.settings.pages.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'pages' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Manage Pages') }}</span></p>
                        </a>
                        <a href="{{ route('admin.settings.extensions.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'extensions' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Extensions') }}</span></p>
                        </a>
                        <a href="{{ route('admin.settings.languages.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'languages' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Languages') }}</span></p>
                        </a>
                        <a href="{{ route('admin.settings.mailtemplates.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'mailtemplates' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Mail Templates') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.settings.seo.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'seo' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title">
                                <span>{{ admin_trans('SEO Configurations') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'others' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-layer-group"></i>{{ admin_trans('Manage Sections') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.features.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'features' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Features') }}</span></p>
                        </a>
                        <a href="{{ route('admin.faqs.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'faqs' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('FAQs') }}</span></p>
                        </a>
                        <a href="{{ route('admin.steps.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'steps' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('How it Works') }}</span></p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'extra' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-square-plus"></i>{{ admin_trans('Extra Features') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.extra.notice') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'popup-notice' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('PopUp Notice') }}</span></p>
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.addons.index') }}"
                    class="vironeer-sidebar-link {{ request()->segment(2) == 'addons' ? 'current' : '' }}">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-puzzle-piece"></i>{{ admin_trans('Addons Manager') }}</span>
                    </p>
                </a>
                <div class="vironeer-sidebar-link {{ request()->segment(2) == 'system' ? 'active' : '' }}"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-server"></i>{{ admin_trans('System') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.system.info.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'info' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Information') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.system.panel-style') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'panel-style' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Panel Style') }}</span>
                            </p>
                        </a>
                        <a href="{{ route('admin.system.editor-files.index') }}"
                            class="vironeer-sidebar-link {{ request()->segment(3) == 'editor-files' ? 'current' : '' }}">
                            <p class="vironeer-sidebar-link-title"><span>{{ admin_trans('Editor Files') }}</span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
