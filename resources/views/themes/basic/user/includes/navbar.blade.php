<div class="nav-bar v2">
    <div class="container-fluid">
        <div class="nav-bar-container">
            <div class="dash-sidebar-btn">
                <i class="fa fa-bars"></i>
            </div>
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset($themeSettings->general->logo_light) }}" alt="{{ $settings->general->site_name }}" />
            </a>
            <div class="nav-bar-menu">
                <div class="overlay"></div>
                <div class="nav-bar-links">
                    <div class="nav-bar-menu-header">
                        <a class="nav-bar-menu-close ms-auto">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    @include('themes.basic.partials.language-menu')
                </div>
            </div>
            <div class="nav-bar-actions">
                <div class="drop-down drop-down-lg ms-3 me-2" data-dropdown data-dropdown-position="top">
                    <div class="drop-down-btn nav-btn announcements-menu-btn" data-id="1">
                        <i class="fa-solid fa-bullhorn"></i>
                        <div class="announcements-menu-counter">{{ $countAnnouncements }}</div>
                    </div>
                    <div class="drop-down-menu">
                        <div class="announcements-menu">
                            <div class="announcements-menu-header">
                                <h6 class="mb-0">{{ translate('Announcements', 'announcements') }}</h6>
                            </div>
                            <div class="announcements-menu-body" data-simplebar>
                                @forelse ($announcements as $announcement)
                                    <div class="d-flex flex-column">
                                        <div class="announcements-menu-item">
                                            <div class="announcements-menu-item-icon">
                                                <i class="fa fa-bullhorn"></i>
                                            </div>
                                            <div class="announcements-menu-item-info">
                                                <p class="announcements-menu-item-text mb-0">{{ $announcement->title }}
                                                </p>
                                                <span
                                                    class="announcements-menu-item-time">{{ $announcement->created_at->diffforhumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <span
                                            class="text-muted">{{ translate('No Announcements Available', 'announcements') }}</span>
                                    </div>
                                @endforelse
                            </div>
                            <div class="announcements-menu-footer">
                                <a href="{{ route('user.announcements') }}">
                                    {{ translate('See all announcements', 'announcements') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @include('themes.basic.partials.user-menu')
                <div class="nav-bar-menu-btn">
                    <i class="fa-solid fa-bars-staggered fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>
