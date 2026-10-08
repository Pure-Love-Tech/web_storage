<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|-------------------------------------------------------------------------
 */
Route::name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@redirectToLogin')->name('index');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login.store');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::middleware('smtp')->group(function () {
            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
            Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        });
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.reset.change');
        Route::middleware('admin')->group(function () {
            Route::get('2fa/verify', 'TwoFactorController@show2FaVerifyForm')->name('2fa.verify');
            Route::post('2fa/verify', 'TwoFactorController@verify2fa');
        });
    });
    Route::group(['middleware' => ['admin', 'admin.2fa']], function () {
        Route::middleware('demo')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');
            Route::name('notifications.')->prefix('notifications')->group(function () {
                Route::get('/', 'NotificationController@index')->name('index');
                Route::get('show/{notification}', 'NotificationController@show')->name('show');
                Route::get('read-all', 'NotificationController@readAll')->name('readall');
                Route::delete('delete-read', 'NotificationController@deleteAllRead')->name('deleteallread');
            });
            Route::name('members.')->prefix('members')->namespace('Members')->group(function () {
                Route::name('users.')->prefix('users')->group(function () {
                    Route::post('destroy-selected', 'UserController@destroySelected')->name('destroy.selected');
                    Route::get('{user}/referrals', 'UserController@referrals')->name('referrals.index');
                    Route::delete('{user}/referrals/{id}', 'UserController@destroyReferral')->name('referrals.destroy');
                    Route::post('{user}/edit/change/avatar', 'UserController@changeAvatar');
                    Route::delete('{user}/edit/delete/avatar', 'UserController@deleteAvatar')->name('deleteAvatar');
                    Route::post('{user}/edit/sendmail', 'UserController@sendMail')->name('sendmail');
                    Route::get('{user}/edit/logs', 'UserController@logs')->name('logs');
                    Route::get('{user}/edit/logs/get/{userLog}', 'UserController@getLogs')->middleware('ajax.only');
                    Route::get('logs/{ip}', 'UserController@logsByIp')->name('logsbyip');
                });
                Route::resource('users', 'UserController');
                Route::resource('admins', 'AdminController');
            });
            Route::name('files.')->prefix('files')->namespace('Files')->group(function () {
                Route::name('users.')->prefix('users')->group(function () {
                    Route::get('/', 'UsersFilesController@index')->name('index');
                    Route::post('destroy-selected', 'UsersFilesController@destroySelected')->name('destroy.selected');
                    Route::get(env('DOWNLOAD_PREFIX') . '/{fileEntry}/{filename}', 'UsersFilesController@download')->name('download');
                    Route::get('{fileEntry}/statistics', 'UsersFilesController@statistics')->name('statistics');
                    Route::get('{fileEntry}', 'UsersFilesController@show')->name('show');
                    Route::post('{fileEntry}/update', 'UsersFilesController@update')->name('update');
                    Route::delete('{fileEntry}', 'UsersFilesController@destroy')->name('destroy');
                });
                Route::name('visitors.')->prefix('visitors')->group(function () {
                    Route::get('/', 'VisitorsFilesController@index')->name('index');
                    Route::post('destroy-selected', 'VisitorsFilesController@destroySelected')->name('destroy.selected');
                    Route::get(env('DOWNLOAD_PREFIX') . '/{fileEntry}/{filename}', 'VisitorsFilesController@download')->name('download');
                    Route::get('{fileEntry}', 'VisitorsFilesController@show')->name('show');
                    Route::post('{fileEntry}/update', 'VisitorsFilesController@update')->name('update');
                    Route::delete('{fileEntry}', 'VisitorsFilesController@destroy')->name('destroy');
                });
                Route::name('reports.')->prefix('reports')->group(function () {
                    Route::get('/', 'ReportedFilesController@index')->name('index');
                    Route::get('{fileReport}', 'ReportedFilesController@show')->name('show');
                    Route::delete('{fileReport}', 'ReportedFilesController@destroy')->name('destroy');
                });
            });
            Route::resource('withdrawals', 'WithdrawalController')->except(['create', 'store', 'show']);
            Route::resource('announcements', 'AnnouncementController');
            Route::name('plans.')->prefix('plans')->middleware('license:1')->group(function () {
                Route::get('/', 'PlanController@index')->name('index');
                Route::get('{plan}/edit', 'PlanController@edit')->name('edit');
                Route::post('{plan}', 'PlanController@update')->name('update');
            });
            Route::name('advertisements.')->prefix('advertisements')->group(function () {
                Route::get('/', 'AdvertisementController@index')->name('index');
                Route::get('{id}/edit', 'AdvertisementController@edit')->name('edit');
                Route::post('{id}', 'AdvertisementController@update')->name('update');
            });
            Route::name('earnings.')->prefix('earnings')->namespace('Earnings')->group(function () {
                Route::get('settings', 'SettingsController@index');
                Route::post('settings', 'SettingsController@update')->name('settings');
                Route::get('statistics', 'StatisticController@index')->name('statistics.index');
                Route::get('records', 'RecordController@index')->name('records.index');
                Route::get('records/{record}', 'RecordController@show')->name('records.show');
                Route::get('reports', 'ReportController@index')->name('reports.index');
                Route::resource('payout-rates', 'PayoutRateController');
                Route::post('withdrawal-methods/sort', 'WithdrawalMethodController@sort')->name('withdrawal-methods.sort');
                Route::resource('withdrawal-methods', 'WithdrawalMethodController');
            });
            Route::name('premium.')->prefix('premium')->namespace('Premium')->middleware('license:2')->group(function () {
                Route::get('settings', 'SettingsController@index');
                Route::post('settings', 'SettingsController@update')->name('settings');
                Route::post('plans/sort', 'PlanController@sort')->name('plans.sort');
                Route::delete('plans/{premium_plan}', 'PlanController@deletePremiumPlan')->name('plans.delete');
                Route::resource('plans', 'PlanController')->except(['create', 'store', 'show', 'destroy']);
                Route::resource('subscriptions', 'SubscriptionController');
                Route::resource('transactions', 'TransactionController')->except(['create', 'store']);
                Route::post('payment-gateways/sort', 'PaymentGatewayController@sort')->name('payment-gateways.sort');
                Route::resource('payment-gateways', 'PaymentGatewayController')->except(['create', 'store', 'show', 'destroy']);
            });
            Route::prefix('navigation')->namespace('Navigation')->middleware('demo')->group(function () {
                Route::post('navbarMenu/nestable', 'NavbarMenuController@nestable')->name('navbarMenu.nestable');
                Route::resource('navbarMenu', 'NavbarMenuController');
                Route::post('footerMenu/nestable', 'FooterMenuController@nestable')->name('footerMenu.nestable');
                Route::resource('footerMenu', 'FooterMenuController');
            });
            Route::group(['prefix' => 'blog', 'as' => 'blog.', 'namespace' => 'Blog', 'middleware' => 'blog'], function () {
                Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
                Route::resource('categories', 'CategoryController');
                Route::get('articles/slug', 'ArticleController@slug')->name('articles.slug');
                Route::get('articles/categories/{lang}', 'ArticleController@getCategories')->middleware('ajax.only');
                Route::resource('articles', 'ArticleController');
                Route::get('comments', 'CommentController@index')->name('comments.index');
                Route::get('comments/{id}/view', 'CommentController@viewComment')->middleware('ajax.only');
                Route::post('comments/{id}/update', 'CommentController@updateComment')->name('comments.update');
                Route::delete('comments/{id}', 'CommentController@destroy')->name('comments.destroy');
            });
            Route::name('appearance.')->prefix('appearance')->namespace('Appearance')->group(function () {
                Route::name('themes.')->prefix('themes')->group(function () {
                    Route::get('/', 'ThemeController@index')->name('index');
                    Route::post('upload', 'ThemeController@upload')->name('upload');
                    Route::post('{theme}/active', 'ThemeController@makeActive')->name('active');
                    Route::name('settings.')->prefix('{theme}/settings')->group(function () {
                        Route::get('/', 'ThemeController@showSettings')->name('index');
                        Route::get('{group}', 'ThemeController@showSettings')->name('group');
                        Route::post('{group}', 'ThemeController@updateSettings')->name('update');
                    });
                    Route::name('custom-css.')->prefix('{theme}/custom-css')->group(function () {
                        Route::get('/', 'ThemeController@showCustomCss')->name('index');
                        Route::post('/', 'ThemeController@updateCustomCss')->name('update');
                    });
                });
            });
        });
        Route::name('settings.')->prefix('settings')->namespace('Settings')->middleware('demo')->group(function () {
            Route::get('general', 'GeneralController@index')->name('general');
            Route::post('general', 'GeneralController@update')->name('general.update');
            Route::get('filesystem', 'FileSystemController@index')->name('filesystem');
            Route::post('filesystem', 'FileSystemController@update')->name('filesystem.update');
            Route::name('oauth-providers.')->prefix('oauth-providers')->group(function () {
                Route::get('/', 'OAuthProviderController@index')->name('index');
                Route::get('{oauthProvider}/edit', 'OAuthProviderController@edit')->name('edit');
                Route::post('{oauthProvider}', 'OAuthProviderController@update')->name('update');
            });
            Route::name('storage.')->prefix('storage')->group(function () {
                Route::get('/', 'StorageController@index')->name('index');
                Route::get('edit/{storageProvider}', 'StorageController@edit')->name('edit');
                Route::post('edit/{storageProvider}', 'StorageController@update')->name('update');
                Route::post('connect/{storageProvider}', 'StorageController@storageTest')->name('test');
                Route::post('default/{storageProvider}', 'StorageController@setDefault')->name('default');
            });
            Route::name('smtp.')->prefix('smtp')->group(function () {
                Route::get('/', 'SmtpController@index')->name('index');
                Route::post('update', 'SmtpController@update')->name('update');
                Route::post('test', 'SmtpController@test')->name('test');
            });
            Route::name('extensions.')->prefix('extensions')->group(function () {
                Route::get('/', 'ExtensionController@index')->name('index');
                Route::get('{extension}/edit', 'ExtensionController@edit')->name('edit');
                Route::post('{extension}', 'ExtensionController@update')->name('update');
            });
            Route::name('mailtemplates.')->prefix('mailtemplates')->group(function () {
                Route::get('/', 'MailTemplateController@index')->name('index');
                Route::post('settings/update', 'MailTemplateController@updateSettings')->name('updateSettings');
                Route::get('{mailTemplate}/edit', 'MailTemplateController@edit')->name('edit');
                Route::post('{mailTemplate}', 'MailTemplateController@update')->name('update');
            });
            Route::get('pages/slug', 'PageController@slug')->name('pages.slug');
            Route::resource('pages', 'PageController');
            Route::name('languages.')->prefix('languages')->group(function () {
                Route::post('sort', 'LanguageController@sort')->name('sort');
                Route::get('translate/{code}', 'LanguageController@translate')->name('translates');
                Route::post('translate/{code}/export', 'LanguageController@export')->name('translates.export');
                Route::post('translate/{code}/import', 'LanguageController@import')->name('translates.import');
                Route::post('{id}/update', 'LanguageController@translateUpdate')->name('translates.update');
                Route::get('translate/{code}/{group}', 'LanguageController@translate')->name('translates.group');
            });
            Route::resource('languages', 'LanguageController');
            Route::resource('seo', 'SeoController');
        });
        Route::name('extra.')->prefix('extra')->namespace('Extra')->middleware('demo')->group(function () {
            Route::get('popup-notice', 'PopupNoticeController@index')->name('notice');
            Route::post('popup-notice/update', 'PopupNoticeController@update')->name('notice.update');
        });
        Route::namespace('Others')->prefix('others')->middleware('demo')->group(function () {
            Route::resource('features', 'FeatureController');
            Route::resource('faqs', 'FaqController');
            Route::resource('steps', 'StepController');
        });
        Route::post('ckeditor/upload', 'CKEditorController@upload');
        Route::name('addons.')->prefix('addons')->group(function () {
            Route::get('/', 'AddonController@index')->name('index');
            Route::post('/', 'AddonController@upload')->name('upload');
            Route::post('{addon}/update', 'AddonController@update')->name('update');
        });
        Route::name('system.')->namespace('System')->prefix('system')->middleware('demo')->group(function () {
            Route::get('info', 'InfoController@index')->name('info.index');
            Route::get('info/cache', 'InfoController@cache')->name('info.cache');
            Route::get('editor-files', 'EditorFileController@index')->name('editor-files.index');
            Route::post('editor-files/upload', 'EditorFileController@upload');
            Route::delete('editor-files/{editorFile}', 'EditorFileController@destroy')->name('editor-files.destroy');
            Route::get('panel-style', 'PanelStyleController@index');
            Route::post('panel-style', 'PanelStyleController@update')->name('panel-style');
        });
        Route::name('account.')->prefix('account')->middleware('demo')->group(function () {
            Route::get('/', 'AccountController@index')->name('index');
            Route::post('details', 'AccountController@updateDetails')->name('details');
            Route::post('password', 'AccountController@updatePassword')->name('password');
            Route::post('2fa/enable', 'AccountController@enable2FA')->name('2fa.enable');
            Route::post('2fa/disable', 'AccountController@disable2FA')->name('2fa.disable');
        });
    });
});
