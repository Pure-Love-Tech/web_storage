<?php

namespace App\Http\Middleware\Backend;

use Auth;
use Closure;
use Illuminate\Http\Request;

class AdminTowFactorVerify
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
        if (Auth::guard('admin')->check() && auth()->guard('admin')->user()->google2fa_status && !$request->session()->has('admin_2fa') &&
            session('admin_2fa') != encrypt(auth()->guard('admin')->user()->id)) {
            return redirect()->route('admin.2fa.verify');
        }
        return $next($request);
    }
}
