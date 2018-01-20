<?php

namespace App\Http\Middleware\Permission;

use Closure;
use Illuminate\Support\Facades\Auth;

class Book
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
		if (Auth::guard($guard)->guest())
		{
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('dashboard/auth/login?_rdi='.$request->path());
            }
        }
		else
		{
			$user = Auth::guard($guard)->user();
			if ( !(($user->role == 'a' || ($user->role == 'e' && $user->permission_book == '1')) && ($user->status == 'a' || $user->role == 'p')) )
			{
				if ($request->ajax() || $request->wantsJson()) {
	                return response('Unauthorized.', 401);
	            } else {
	                return redirect()->guest('dashboard/auth/login?_rdi='.$request->path());
	            }
			}
		}

        return $next($request);
    }
}
