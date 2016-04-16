<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class SetViewVariable
{

    use Helpers;

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            $notifications = $this->api->be(Auth::user())->get('/api/notifications');
            view()->share('menu_notifications', $notifications);
        }
        return $next($request);
    }

}
