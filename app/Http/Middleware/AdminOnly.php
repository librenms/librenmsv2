<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->user()->isAdmin()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response(trans('general.text.unauthorized'), 401);
            } else {
                //FIXME: Errors not working
                return redirect('/')->withErrors(['msg', trans('general.text.unauthorized')]);
            }
        }

        return $next($request);
    }
}
