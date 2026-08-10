<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SetReferralMiddleware
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
        // Check if the 'ref' parameter is present in the request
        if ($request->has('ref')) {
            // Check if the user is not logged in
            if (!Auth::user()) {
                // Find the user with the specified username in the 'ref' parameter
                $referrer = User::where('username', $request->ref)->first();
                // If a user is found with the specified username
                if ($referrer) {
                    // Set the '_ref' cookie with the referrer's username
                    Cookie::queue('_ref', $referrer->username);
                }
            }
            // Redirect the user to the home page
            return redirect()->route('home');
        }

        return $next($request);
    }
}
