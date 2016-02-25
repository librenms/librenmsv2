<?php

namespace App\Http\Controllers;

use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Helpers;

    public function __construct(Request $request) {
        $this->middleware('auth');
    }

    public function index() {
        return view('home');
    }

    public function devices() {
        $devices = $this->api->be(auth()->user())->get('/api/devices');
        return view('devices.list', ['devices'=>$devices]);
    }

    public function about() {
        $versions = $this->api->be(auth()->user())->get('/api/info');
        $versions['git'] = `git rev-parse --short HEAD`;
        return view('general.about', ['versions'=>$versions]);
    }
}
