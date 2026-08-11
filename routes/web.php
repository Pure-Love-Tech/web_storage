<?php

use App\Methods\LocalizationRouteGroup;
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
Route::group(LocalizationRouteGroup::build(), function () {
    Route::get('cookie/accept', 'GlobalController@cookie')->middleware('ajax.only');
    Route::get('popup/close', 'GlobalController@popup')->middleware('ajax.only');
    Auth::routes(['verify' => true]);
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('login/{provider}', 'LoginController@redirectToProvider')->name('provider.login');
        Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback')->name('provider.callback');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::middleware(['disable.registration'])->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register')->middleware('check.registration');
        });
        Route::name('oauth.')->prefix('oauth')->group(function () {
            Route::get('{provider}', 'OAuthController@redirectToProvider')->name('login');
            Route::get('{provider}/callback', 'OAuthController@handleProviderCallback')->name('callback');
            Route::middleware(['auth'])->group(function () {
                Route::get('data/complete', 'OAuthController@showCompleteForm');
                Route::post('data/complete', 'OAuthController@complete')->name('data.complete');
            });
        });
        Route::middleware('smtp')->group(function () {
            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        });
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::middleware('oauth.complete')->group(function () {
            Route::middleware('smtp')->group(function () {
                Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
                Route::post('email/verify/email/change', 'VerificationController@changeEmail')->name('change.email');
                Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
                Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
            });
            Route::middleware(['auth', 'verified'])->group(function () {
                Route::get('2fa/verify', 'TwoFactorController@show2FaVerifyForm');
                Route::post('2fa/verify', 'TwoFactorController@verify2fa')->name('2fa.verify');
            });
        });
    });
    Route::prefix('user')->namespace('User')->middleware(['auth', 'oauth.complete', 'verified', 'user.2fa'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('user.dashboard');
        })->name('user');
        Route::name('user.')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');
            Route::name('files.')->prefix('files')->group(function () {
                Route::get('/', 'FileController@index')->name('index');
                Route::get('{id}/statistics', 'FileController@statistics')->name('statistics');
                Route::get(env('DOWNLOAD_PREFIX') . '/{shared_id}/{filename}', 'FileController@download')->name('download');
            });
            Route::get('announcements', 'AnnouncementController@index')->name('announcements');
            Route::name('withdrawals.')->prefix('withdrawals')->group(function () {
                Route::get('/', 'WithdrawalController@index')->name('index');
                Route::post('/', 'WithdrawalController@withdraw')->name('withdraw');
            });
            Route::get('referrals', 'ReferralController@index')->name('referrals');
            Route::name('settings.')->prefix('settings')->group(function () {
                Route::get('/', 'SettingsController@index')->name('index');
                Route::post('details', 'SettingsController@detailsUpdate')->name('details.update');
                Route::get('password', 'SettingsController@password')->name('password');
                Route::post('password', 'SettingsController@passwordUpdate')->name('password.update');
                Route::get('2fa', 'SettingsController@towFactor')->name('2fa');
                Route::post('2fa/enable', 'SettingsController@towFactorEnable')->name('2fa.enable');
                Route::post('2fa/disabled', 'SettingsController@towFactorDisable')->name('2fa.disable');
                Route::get('withdrawal', 'SettingsController@withdrawal')->name('withdrawal');
                Route::post('withdrawal', 'SettingsController@withdrawalUpdate')->name('withdrawal.update');
                Route::middleware('license:2')->group(function () {
                    Route::get('subscription', 'SettingsController@subscription')->name('subscription');
                    Route::post('subscription', 'SettingsController@cancelSubscription')->name('subscription.cancel');
                });
            });
        });
    });
    Route::middleware(['verified', 'user.2fa'])->group(function () {
        Route::get('/', 'HomeController@index')->name('home')->middleware('referral');
        Route::name('files.')->namespace('Files')->group(function () {
            Route::post('upload', 'UploadController@upload')->name('upload');
            Route::middleware(['files.hasNoPassword'])->group(function () {
                Route::get('{id}/password', 'PasswordController@index')->middleware('referrer');
                Route::post('{id}/password', 'PasswordController@unlock')->name('password');
            });
            Route::middleware('files.hasPassword')->group(function () {
                Route::get('{id}/folder', 'FolderController@index')->name('folder');
                Route::get('{id}/file', 'FileController@index')->middleware('referrer');
                Route::post('{id}/file', 'FileController@action')->name('file');
                Route::post('{id}/file/report', 'FileController@reportFile')->name('file.report');
                Route::post('{id}/file/generate', 'FileController@generateDownloadLink');
            });
            Route::get(env('DOWNLOAD_PREFIX') . '/{id}/{filename}', 'FileController@download')->name('download');
        });
        Route::name('premium.')->prefix('premium')->namespace('Premium')->middleware('license:2')->group(function () {
            Route::get('/', 'PremiumController@index')->name('index');
            Route::post('/', 'PremiumController@subscribe')->name('subscribe');
        });
        Route::get('payout-rates', 'GlobalController@payoutRates')->name('payout-rates')->middleware('payout_rates');
        Route::get('payment-proof', 'GlobalController@paymentProof')->name('payment-proof')->middleware('payment_proof');
        Route::get('faqs', 'GlobalController@faq')->name('faqs');

        Route::name('blog.')->prefix('blog')->middleware('blog')->group(function () {
            Route::get('/', 'BlogController@index')->name('index');
            Route::get('categories', 'BlogController@categories')->name('categories');
            Route::get('categories/{slug}', 'BlogController@category')->name('category');
            Route::get('articles', 'BlogController@articles');
            Route::get('articles/{slug}', 'BlogController@article');
            Route::post('articles/{slug}', 'BlogController@comment')->name('article');
        });
        Route::middleware('contact')->group(function () {
            Route::get('contact-us', 'GlobalController@contact');
            Route::post('contact-us', 'GlobalController@contactSend')->name('contact');
        });
        if (config('vironeer.install.complete') && !settings('actions')->language_type) {
            Route::get('{lang}', 'LocalizationController@localize')->where('lang', '^[a-z]{2}$')->name('localize');
        }
        Route::get('{slug}', 'GlobalController@page')->name('page');
    });
});
