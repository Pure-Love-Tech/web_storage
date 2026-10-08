<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SwitchDemoType::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'demo' => \App\Http\Middleware\DemoMode::class,
        'smtp' => \App\Http\Middleware\SmtpMiddleware::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'oauth.complete' => \App\Http\Middleware\OAuthDataComplete::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'app.localize' => \App\Http\Middleware\Localization::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        'admin' => \App\Http\Middleware\Backend\RedirectNotAdmin::class,
        'admin.guest' => \App\Http\Middleware\Backend\RedirectAdmin::class,
        'admin.2fa' => \App\Http\Middleware\Backend\AdminTowFactorVerify::class,
        'ajax.only' => \App\Http\Middleware\AjaxOnlyMiddleware::class,
        'check.registration' => \App\Http\Middleware\Actions\RegistrationStatusCheck::class,
        'disable.registration' => \App\Http\Middleware\Actions\RegistrationDisable::class,
        'user.status' => \App\Http\Middleware\UserStatusCheck::class,
        'user.2fa' => \App\Http\Middleware\UserTowFactorVerify::class,
        'license' => \App\Http\Middleware\LicenseMiddleware::class,
        'blog' => \App\Http\Middleware\Actions\BlogAction::class,
        'contact' => \App\Http\Middleware\Actions\ContactAction::class,
        'payout_rates' => \App\Http\Middleware\Actions\PayoutRatesAction::class,
        'payment_proof' => \App\Http\Middleware\Actions\PaymentProofAction::class,
        'referral' => \App\Http\Middleware\SetReferralMiddleware::class,
        'referrer' => \App\Http\Middleware\SetRefererMiddleware::class,
        'files.hasPassword' => \App\Http\Middleware\Files\FileHasPassword::class,
        'files.hasNoPassword' => \App\Http\Middleware\Files\FileHasNoPassword::class,
    ];
}
