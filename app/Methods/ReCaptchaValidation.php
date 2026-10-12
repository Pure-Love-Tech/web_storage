<?php

namespace App\Methods;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Scyllaly\HCaptcha\Facades\HCaptcha;

class ReCaptchaValidation
{
    public const PROVIDERS = [
        'google_recaptcha' => [
            'library' => [NoCaptcha::class, 'renderJs'],
            'display' => [NoCaptcha::class, 'display'],
            'rule' => [
                'g-recaptcha-response' => ['required', 'captcha'],
            ],
        ],
        'hcaptcha' => [
            'library' => [HCaptcha::class, 'renderJs'],
            'display' => [HCaptcha::class, 'display'],
            'rule' => [
                'h-captcha-response' => ['required', 'HCaptcha'],
            ],
        ],
    ];

    public static function validate()
    {
        $provider = static::getCaptchaProvider();
        return $provider ? $provider['rule'] : [];
    }

    public static function display($attributes = [])
    {
        $provider = static::getCaptchaProvider();
        return $provider ? '<div class="mb-3">' . static::callMethod($provider['display'], $attributes) . '</div>' : null;
    }

    public static function defaultCaptchaLibrary()
    {
        $provider = static::getCaptchaProvider();
        return $provider?static::callMethod($provider['library'], getLocale()) : null;
    }

    public static function getCaptchaProvider()
    {
        $defaultProvider = settings('general')->default_captcha;
        if (!array_key_exists($defaultProvider, static::PROVIDERS) ||
            extension($defaultProvider)->status != 1) {
            return null;
        }
        return static::PROVIDERS[$defaultProvider];
    }

    public static function callMethod(array $callable, ...$args)
    {
        return call_user_func($callable, ...$args);
    }
}
