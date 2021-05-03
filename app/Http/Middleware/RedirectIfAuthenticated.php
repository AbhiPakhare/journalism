<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Role;
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
        if (Auth::guard($guard)->check()) {
            $role = auth()->user()->role->name;
            switch ($role) {
                case Role::ADMIN:
                    return redirect('/admin/dashboard');
                    break;
                case Role::MANAGER:
                    return redirect('/manager/dashboard');
                    break;
                case Role::REVIEWER:
                    return redirect('/reviewer/dashboard');
                    break;
                case Role::USER:
                    return redirect('/user/dashboard');
                    break;
                default:
                    return redirect('/home');
                    break;
            }
        }

        return $next($request);
    }
}
