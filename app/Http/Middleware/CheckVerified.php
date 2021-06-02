<?php

namespace App\Http\Middleware;

use Closure;

class CheckVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (! auth()->user()->is_verified) {
                auth()->logout();
                return  redirect()->route('password.update')->with('message', 'Kindly reset password to access portal');
            }
        }
        return $next($request);
    }
}
