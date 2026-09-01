<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Backend\AdminNotification;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\FileEntry;
use App\Models\FileReport;
use App\Models\FooterMenu;
use App\Models\Language;
use App\Models\NavbarMenu;
use App\Models\SeoConfiguration;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Rules\BlockPatterns;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerBladeDirectives();
    }

    public function boot()
    {
        Paginator::useBootstrap();

        $this->validationExtends();

        if (config('vironeer.install.complete')) {

            if (settings('actions')->force_ssl_status) {
                $this->app['request']->server->set('HTTPS', true);
            }

            if (settings('actions')->language_type) {
                Config::set('laravellocalization.supportedLocales', getSupportedLocales());
            }

            View::composer('*', function ($view) {
                $view->with(['settings' => settings(), 'themeSettings' => themeSettings()]);
            });

            $this->themeViewComposers();

            $this->backendViewComposers();
        }

        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }

    public function themeViewComposers()
    {
        theme_compose('*', function ($view) {
            $languages = Language::orderBy('sort_id', 'asc')->get();
            $activeLanguage = Language::where('code', getLocale())->first();
            $view->with(['languages' => $languages, 'activeLanguage' => $activeLanguage]);
        });

        theme_compose(['home', 'includes.meta-tags'], function ($view) {
            $seoConfiguration = SeoConfiguration::where('lang', getLocale())->with('language')->first();
            $view->with('seoConfiguration', $seoConfiguration);
        });

        theme_compose('includes.navbar', function ($view) {
            $navbarMenuLinks = NavbarMenu::where('lang', getLocale())
                ->whereNull('parent_id')->with(['children' => function ($query) {
                $query->byOrder();
            }])->byOrder()->get();
            $view->with('navbarMenuLinks', $navbarMenuLinks);
        });

        theme_compose('includes.footer', function ($view) {
            $footerMenuLinks = FooterMenu::where('lang', getLocale())->whereNull('parent_id')->with(['children' => function ($query) {
                $query->byOrder();
            }])->byOrder()->get();
            $view->with('footerMenuLinks', $footerMenuLinks);
        });

        theme_compose('blog.includes.sidebar', function ($view) {
            $blogCategories = BlogCategory::where('lang', getLocale())->get();
            $popularBlogArticles = BlogArticle::where('lang', getLocale())->orderbyDesc('views')->limit(8)->get();
            $view->with(['blogCategories' => $blogCategories, 'popularBlogArticles' => $popularBlogArticles]);
        });

        theme_compose('user.includes.navbar', function ($view) {
            $announcements = Announcement::where('lang', getLocale())->active()->orderByDesc('id')->limit(10)->get();
            $countAnnouncements = Announcement::where('lang', getLocale())->active()->count();
            $view->with(['announcements' => $announcements, 'countAnnouncements' => $countAnnouncements]);
        });

        theme_compose('user.layouts.app', function ($view) {
            $startMonth = Carbon::parse(auth()->user()->created_at)->startOfMonth();
            $currentMonth = Carbon::now()->startOfMonth();
            $months = [];
            while ($startMonth->lte($currentMonth)) {
                $months[] = [
                    "key" => $startMonth->format('Y-m'),
                    "value" => $startMonth->format('F Y'),
                ];
                $startMonth->addMonth();
            }
            $dates = collect($months)->sortByDesc('key');
            $view->with('dates', $dates);
        });

        theme_compose(['includes.uploadbox', 'livewire.files.move-modal'], function ($view) {
            if (auth()->user()) {
                $folders = FileEntry::forUser(auth()->user()->id)->folder()->orderBy('updated_at')->get();
                $folderOptions = $folders->map(function ($folder) {
                    return [
                        'value' => $folder->id,
                        'label' => $folder->getFullPathAttribute(),
                    ];
                });
                $view->with('folderOptions', $folderOptions);
            }
        });

    }

    public function backendViewComposers()
    {
        View::composer('*', function ($view) {
            $adminLanguages = Language::all();
            $view->with('adminLanguages', $adminLanguages);
        });

        View::composer('backend.includes.navbar', function ($view) {
            $adminNotifications = AdminNotification::orderbyDesc('id')->limit(20)->get();
            $unreadAdminNotifications = AdminNotification::where('status', 0)->get()->count();
            $unreadAdminNotificationsAll = $unreadAdminNotifications;
            if ($unreadAdminNotifications > 9) {
                $unreadAdminNotifications = "9+";
            }
            $view->with([
                'adminNotifications' => $adminNotifications,
                'unreadAdminNotifications' => $unreadAdminNotifications,
                'unreadAdminNotificationsAll' => $unreadAdminNotificationsAll,
            ]);
        });

        View::composer('backend.includes.sidebar', function ($view) {
            $sidebar_counters['users'] = User::where('is_viewed', 0)->count();
            $sidebar_counters['users_files'] = FileEntry::file()->forUsers()->where('is_viewed', 0)->count();
            $sidebar_counters['visitors_files'] = FileEntry::file()->forVisitors()->where('is_viewed', 0)->count();
            $sidebar_counters['reported_files'] = FileReport::where('is_viewed', 0)->count();
            $sidebar_counters['withdrawals'] = Withdrawal::where('is_viewed', 0)->count();
            $sidebar_counters['subscriptions'] = Subscription::where('is_viewed', 0)->count();
            $sidebar_counters['transactions'] = Transaction::where('is_viewed', 0)->count();
            $sidebar_counters['comments'] = BlogComment::where('status', 0)->get()->count();
            $view->with('sidebar_counters', $sidebar_counters);
        });
    }

    public function validationExtends()
    {
        Validator::extend('block_patterns', function ($attribute, $value, $parameters, $validator) {
            $rule = new BlockPatterns;
            return $rule->passes($attribute, $value);
        });
    }

    public function registerBladeDirectives()
    {
        Blade::directive('themeColors', function () {
            return '<link rel="stylesheet" href="' . theme_asset(config('theme.style.colors')) . '">';
        });

        Blade::directive('themeCustomStyle', function () {
            return '<link rel="stylesheet" href="' . theme_asset(config('theme.style.custom_css')) . '">';
        });

        Blade::directive('backendColors', function () {
            return '<link rel="stylesheet" href="' . asset(config('backend.css.colors')) . '">';
        });

        Blade::directive('backendCustomStyle', function () {
            return '<link rel="stylesheet" href="' . asset(config('backend.css.custom')) . '">';
        });
    }
}
