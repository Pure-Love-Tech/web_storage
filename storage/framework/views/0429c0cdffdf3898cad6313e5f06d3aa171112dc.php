<aside class="vironeer-sidebar">
    <div class="overlay"></div>
    <div class="vironeer-sidebar-header">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="vironeer-sidebar-logo">
            <img src="<?php echo e(asset($themeSettings->general->logo_light)); ?>" alt="<?php echo e($settings->general->site_name); ?>" />
        </a>
    </div>
    <div class="vironeer-sidebar-menu" data-simplebar>
        <div class="vironeer-sidebar-links">
            <div class="vironeer-sidebar-links-cont">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'dashboard' ? 'current' : ''); ?>">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-table-columns"></i><?php echo e(admin_trans('Dashboard')); ?></span>
                    </p>
                </a>
                <div class="vironeer-sidebar-link  <?php echo e(request()->segment(2) == 'members' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span class="w-100">
                            <span><i class="fas fa-users"></i><?php echo e(admin_trans('Members')); ?></span>
                        </span>
                        <?php if($sidebar_counters['users']): ?>
                            <span class="counter me-2"><?php echo e($sidebar_counters['users']); ?></span>
                        <?php endif; ?>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.members.users.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'users' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('Users')); ?></span>
                                <?php if($sidebar_counters['users']): ?>
                                    <span class="counter"><?php echo e($sidebar_counters['users']); ?></span>
                                <?php endif; ?>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.members.admins.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'admins' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Admins')); ?></span></p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'files' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span class="w-100">
                            <i class="fa-regular fa-folder-open"></i><?php echo e(admin_trans('Manage Files')); ?>

                        </span>
                        <?php if($sidebar_counters['users_files'] || $sidebar_counters['visitors_files'] || $sidebar_counters['reported_files']): ?>
                            <span
                                class="counter me-2"><?php echo e($sidebar_counters['users_files'] + $sidebar_counters['visitors_files'] + $sidebar_counters['reported_files']); ?></span>
                        <?php endif; ?>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.files.users.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'users' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('Users Files')); ?></span>
                                <?php if($sidebar_counters['users_files']): ?>
                                    <span class="counter"><?php echo e($sidebar_counters['users_files']); ?></span>
                                <?php endif; ?>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.files.visitors.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'visitors' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('Visitors Files')); ?></span>
                                <?php if($sidebar_counters['visitors_files']): ?>
                                    <span class="counter"><?php echo e($sidebar_counters['visitors_files']); ?></span>
                                <?php endif; ?>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.files.reports.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'reports' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('Reported Files')); ?></span>
                                <?php if($sidebar_counters['reported_files']): ?>
                                    <span class="counter"><?php echo e($sidebar_counters['reported_files']); ?></span>
                                <?php endif; ?>
                            </p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-links-cont">
                    <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'earnings' ? 'active' : ''); ?>"
                        data-dropdown>
                        <p class="vironeer-sidebar-link-title">
                            <span><i class="fa-solid fa-dollar-sign"></i><?php echo e(admin_trans('Earnings')); ?></span>
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="vironeer-sidebar-link-menu">
                            <a href="<?php echo e(route('admin.earnings.settings')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'settings' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Settings')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.earnings.statistics.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'statistics' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Statistics')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.earnings.records.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'records' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Records')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.earnings.reports.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'reports' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Reports')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.earnings.payout-rates.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'payout-rates' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Payout Rates')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.earnings.withdrawal-methods.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'withdrawal-methods' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title">
                                    <span><?php echo e(admin_trans('Withdrawal Methods')); ?></span>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.withdrawals.index')); ?>"
                    class="vironeer-sidebar-link <?php if(request()->segment(2) == 'withdrawals'): ?> current <?php endif; ?>">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-money-bill-transfer"></i><?php echo e(admin_trans('Withdrawals')); ?></span>
                        <?php if($sidebar_counters['withdrawals']): ?>
                            <span class="counter"><?php echo e($sidebar_counters['withdrawals']); ?></span>
                        <?php endif; ?>
                    </p>
                </a>
                <a href="<?php echo e(route('admin.announcements.index')); ?>"
                    class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'announcements' ? 'current' : ''); ?>">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-bullhorn"></i><?php echo e(admin_trans('Announcements')); ?></span>
                    </p>
                </a>
                <?php if(licenseType(1)): ?>
                    <a href="<?php echo e(route('admin.plans.index')); ?>"
                        class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'plans' ? 'current' : ''); ?>">
                        <p class="vironeer-sidebar-link-title">
                            <span><i class="fa-solid fa-cubes"></i><?php echo e(admin_trans('Manage Plans')); ?></span>
                        </p>
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('admin.advertisements.index')); ?>"
                    class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'advertisements' ? 'current' : ''); ?>">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-ad"></i><?php echo e(admin_trans('Advertisements')); ?></span>
                    </p>
                </a>
            </div>
            <?php if(licenseType(2)): ?>
                <div class="vironeer-sidebar-links-cont">
                    <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'premium' ? 'active' : ''); ?>"
                        data-dropdown>
                        <p class="vironeer-sidebar-link-title">
                            <span class="w-100"><i class="fa-regular fa-gem"></i><?php echo e(admin_trans('Premium')); ?></span>
                            <?php if($sidebar_counters['subscriptions'] || $sidebar_counters['transactions']): ?>
                                <span
                                    class="counter me-2"><?php echo e($sidebar_counters['subscriptions'] + $sidebar_counters['transactions']); ?></span>
                            <?php endif; ?>
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="vironeer-sidebar-link-menu">
                            <a href="<?php echo e(route('admin.premium.settings')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'settings' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Settings')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.premium.plans.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'plans' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Plans')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.premium.subscriptions.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'subscriptions' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Subscriptions')); ?></span>
                                    <?php if($sidebar_counters['subscriptions']): ?>
                                        <span class="counter"><?php echo e($sidebar_counters['subscriptions']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.premium.transactions.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'transactions' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Transactions')); ?></span>
                                    <?php if($sidebar_counters['transactions']): ?>
                                        <span class="counter"><?php echo e($sidebar_counters['transactions']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.premium.payment-gateways.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'payment-gateways' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title">
                                    <span><?php echo e(admin_trans('Payment Gateways')); ?></span>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'navigation' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-bars"></i><?php echo e(admin_trans('Navigation')); ?></span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.navbarMenu.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'navbarMenu' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Navbar Menu')); ?></span></p>
                        </a>
                        <a href="<?php echo e(route('admin.footerMenu.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'footerMenu' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Footer Menu')); ?></span></p>
                        </a>
                    </div>
                </div>
                <?php if($settings->actions->blog_status): ?>
                    <div class="vironeer-sidebar-link  <?php echo e(request()->segment(2) == 'blog' ? 'active' : ''); ?>"
                        data-dropdown>
                        <p class="vironeer-sidebar-link-title">
                            <span><i class="fas fa-rss"></i><?php echo e(admin_trans('Blog')); ?></span>
                            <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                        </p>
                        <div class="vironeer-sidebar-link-menu">
                            <a href="<?php echo e(route('admin.blog.articles.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'articles' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Articles')); ?></span></p>
                            </a>
                            <a href="<?php echo e(route('admin.blog.categories.index')); ?>"
                                class="vironeer-sidebar-link  <?php echo e(request()->segment(3) == 'categories' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Categories')); ?></span>
                                </p>
                            </a>
                            <a href="<?php echo e(route('admin.blog.comments.index')); ?>"
                                class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'comments' ? 'current' : ''); ?>">
                                <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Comments')); ?></span>
                                    <?php if($sidebar_counters['comments']): ?>
                                        <span class="counter"><?php echo e($sidebar_counters['comments']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'appearance' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-brush"></i><?php echo e(admin_trans('Appearance')); ?></span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.appearance.themes.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'themes' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('Themes')); ?></span>
                            </p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'settings' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-cog"></i><?php echo e(admin_trans('Settings')); ?></span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.settings.general')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'general' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('General Information')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.filesystem')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'filesystem' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('File System')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.oauth-providers.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'oauth-providers' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('OAuth Providers')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.storage.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'storage' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('Storage Providers')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.smtp.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'smtp' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('SMTP Information')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.pages.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'pages' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Manage Pages')); ?></span></p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.extensions.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'extensions' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Extensions')); ?></span></p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.languages.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'languages' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Languages')); ?></span></p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.mailtemplates.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'mailtemplates' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Mail Templates')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.settings.seo.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'seo' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title">
                                <span><?php echo e(admin_trans('SEO Configurations')); ?></span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'others' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-layer-group"></i><?php echo e(admin_trans('Manage Sections')); ?></span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.features.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'features' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Features')); ?></span></p>
                        </a>
                        <a href="<?php echo e(route('admin.faqs.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'faqs' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('FAQs')); ?></span></p>
                        </a>
                        <a href="<?php echo e(route('admin.steps.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'steps' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('How it Works')); ?></span></p>
                        </a>
                    </div>
                </div>
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'extra' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-square-plus"></i><?php echo e(admin_trans('Extra Features')); ?></span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.extra.notice')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'popup-notice' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('PopUp Notice')); ?></span></p>
                        </a>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.addons.index')); ?>"
                    class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'addons' ? 'current' : ''); ?>">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-puzzle-piece"></i><?php echo e(admin_trans('Addons Manager')); ?></span>
                    </p>
                </a>
                <div class="vironeer-sidebar-link <?php echo e(request()->segment(2) == 'system' ? 'active' : ''); ?>"
                    data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa-solid fa-server"></i><?php echo e(admin_trans('System')); ?></span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="<?php echo e(route('admin.system.info.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'info' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Information')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.system.panel-style')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'panel-style' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Panel Style')); ?></span>
                            </p>
                        </a>
                        <a href="<?php echo e(route('admin.system.editor-files.index')); ?>"
                            class="vironeer-sidebar-link <?php echo e(request()->segment(3) == 'editor-files' ? 'current' : ''); ?>">
                            <p class="vironeer-sidebar-link-title"><span><?php echo e(admin_trans('Editor Files')); ?></span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH /var/www/html/arahcloud/resources/views/backend/includes/sidebar.blade.php ENDPATH**/ ?>