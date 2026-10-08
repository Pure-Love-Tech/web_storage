<?php

namespace App\Methods;

use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocalizationRouteGroup
{
    public static function build()
    {
        if (Config::get('vironeer.install.complete')) {
            return self::getLocalizedRouteConfig();
        } else {
            return self::getNotInstalledRouteConfig();
        }
    }

    private static function getLocalizedRouteConfig()
    {
        $middleware = ['user.status', 'notInstalled'];

        if (settings('actions')->language_type) {
            return [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => array_merge($middleware, ['localize', 'localizationRedirect', 'localeSessionRedirect']),
            ];
        } else {
            return [
                'middleware' => array_merge($middleware, ['app.localize']),
            ];
        }
    }

    private static function getNotInstalledRouteConfig()
    {
        return [
            'middleware' => ['notInstalled'],
        ];
    }
}
