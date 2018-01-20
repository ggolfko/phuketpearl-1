<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DashboardRedirectIfAuthenticated
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
        if (Auth::guard($guard)->check())
		{
			$user = Auth::guard($guard)->user();
			if (($user->role == 'a' || $user->role == 'e') && ($user->status == 'a' || $user->status == 'p'))
			{
				return redirect('dashboard');
			}
        }

        return $next($request);
    }
}
