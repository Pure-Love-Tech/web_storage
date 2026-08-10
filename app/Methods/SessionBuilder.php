<?php

namespace App\Methods;

use Illuminate\Support\Str;

class SessionBuilder
{
    public static function sessionName()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uriSegments = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            if (str_contains($uriSegments, adminPath() . '/')) {
                $name = Str::slug(env('APP_NAME', 'laravel'), '_') . '_admin_session';
            } else {
                $name = Str::slug(env('APP_NAME', 'laravel'), '_') . '_user_session';
            }
        } else {
            $name = Str::slug(env('APP_NAME', 'laravel'), '_') . '_session';
        }
        return $name;
    }
}
