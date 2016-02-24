<?php

namespace App\Api\Controllers;

use App\Devices;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct() {

    }

    public function list_devices(Request $request) {
        if ($request->user()->level >= 10 || $request->user()->level == 5) {
            return Devices::all();
        }
        else {
            return User::find($request->user()->user_id)->devices()->get();
        }
    }
}
