<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

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
        /*if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);*/
        if (auth('web')->check()) {//el guard li esmo web men auth.php
            return redirect(RouteServiceProvider::HOME);
        }

        if (auth('student')->check()) {
            return redirect(RouteServiceProvider::STUDENT);
        }

        if (auth('teacher')->check()) {
            return redirect(RouteServiceProvider::TEACHER);
        }

        if (auth('parent')->check()) {
            return redirect(RouteServiceProvider::PARENT);
        }

        return $next($request);
    }
}
