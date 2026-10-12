<?php

namespace App\Http\Middleware\Files;

use App\Models\FileEntry;
use Closure;
use Illuminate\Http\Request;

class FileHasNoPassword
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
        $parameters = $request->route()->parameters();
        if ($parameters['id']) {
            $fileEntry = FileEntry::whereHashId($parameters['id'])->public()->first();
            if ($fileEntry) {
                $passwordSessionPrefix = "password_" . $fileEntry->sharedId();
                if (!$fileEntry->hasPassword() || session()->has($passwordSessionPrefix) &&
                    session($passwordSessionPrefix) == $fileEntry->password) {
                    return redirect($fileEntry->sharedLink());
                }
            }
        }
        return $next($request);
    }
}
