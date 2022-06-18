<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Artisan;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!file_exists( 'installed.txt' ))
		{
            Artisan::call('cache:clear');
			Artisan::call('route:clear');
			Artisan::call('view:clear');
			Artisan::call('config:clear');
            return redirect()->route('installation_form');
        }

        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
