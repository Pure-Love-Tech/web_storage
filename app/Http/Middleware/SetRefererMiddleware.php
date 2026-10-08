<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class SetRefererMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            // Get the referer header from the HTTP request
            $referer = $request->headers->get('referer');

            // Check if the referer header exists and is not empty
            if ($referer) {
                // Check if the referer header is a valid URL
                if (URL::isValidUrl($referer)) {
                    // Parse the referer URL and check if it's an internal or external referer
                    $parseUrl = parse_url($referer);
                    $isInternalReferer = $parseUrl['host'] === parse_url(url('/'), PHP_URL_HOST);
                    // If the referer is external, set the _referer cookie with encrypted host, path, and URL information
                    if (!$isInternalReferer) {
                        $data['url'] = $request->url();
                        $data['referer'] = $referer;
                        $data['host'] = $parseUrl['host'];
                        $data['path'] = $parseUrl['path'];
                        $data['is_blocked'] = false;
                        // Retrieves the list of blocked referrers from the earnings security settings.
                        $blockedReferrers = settings('earnings')->security->blocked_referrers;
                        // Check if the parsed URL's host is in the list of blocked referrers.
                        if ($blockedReferrers) {
                            $arr = explode(',', $blockedReferrers);
                            if (in_array($parseUrl['host'], $arr)) {
                                $data['is_blocked'] = true;
                            }
                        }
                    }
                } else {
                    // If the referer header is not a valid URL, set the _referer cookie with encrypted referer information
                    $data['url'] = $request->url();
                    $data['referer'] = $referer;
                    $data['host'] = null;
                    $data['path'] = null;
                    $data['is_blocked'] = false;
                }
                // Encrypt the data and set the _referer cookie with a lifespan of 24 hours (1440 minutes)
                $encryptedData = encrypt($data);
                Cookie::queue('_referer', $encryptedData, 1440);
            }
        } catch (\Exception $e) {
            // If an exception is thrown, simply return the next middleware in the chain
            return $next($request);
        }

        return $next($request);
    }
}