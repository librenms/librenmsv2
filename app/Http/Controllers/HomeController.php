<?php

namespace App\Http\Controllers;

use Dingo\Api\Http;
use Dingo\Api\Routing\Router;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use Illuminate\Http\Request;
use JWTAuth;

class HomeController extends Controller
{
    use Helpers;

    public function __construct(Request $request) {
        $this->middleware('auth');
    }

    public function index() {
        return view('home');
    }
}
