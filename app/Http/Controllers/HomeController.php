<?php

namespace App\Http\Controllers;

use Api;
use App\Models\Dashboard;
use Auth;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;

class HomeController extends Controller
{
    use Helpers;

    public function redirect(Request $request)
    {
        dd($request->user());
        $dashboard = Dashboard::where('user_id', $request->user()->user_id)->first();
        if (empty($dashboard->dashboard_id))
        {
            $dashboard = new Dashboard();
            $dashboard->dashboard_name = 'Default';
            $dashboard->access         = 0;
            $request->user()->dashboards()->save($dashboard);
        }
        return redirect()->route('dashboard.show', ['id' => $dashboard->dashboard_id]);
    }

    public function index(Request $request) {
        $dashboards = Api::be(auth()->user())->get('/api/dashboard');
        return view('home', ['dashboards' => $dashboards, 'request' => $request]);
    }

    public function show(Request $request)
    {
        $token      = JWTAuth::fromUser(auth()->user());
        $dashboards = Api::be(auth()->user())->get('/api/dashboard');
        if (Dashboard::find($request->route('dashboard_id')))
        {
            $dash    = Api::be(auth()->user())->get('/api/dashboard/'.$request->route('dashboard_id'));
            $widgets = Api::be(auth()->user())->get('/api/widget');
        }
        else {
            return redirect()->route('home');
        }
        return view('home', ['dashboards' => $dashboards, 'request' => $request, 'dash_widgets' => $dash['widgets'], 'token' => $token, 'dash_details' => $dash['dashboard'], 'widgets' => $widgets]);
    }

    public function about() {
        $versions = Api::be(auth()->user())->get('/api/info');
        $stats    = Api::be(auth()->user())->get('/api/stats');
        return view('general.about', ['versions' => $versions, 'stats' => $stats]);
    }
}
