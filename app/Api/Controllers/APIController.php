<?php

namespace App\Api\Controllers;

use App\Device;
use App\User;

use App\Http\Requests;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct() {

    }

    public function list_devices(Request $request) {
        if ($request->user()->level >= 10 || $request->user()->level == 5) {
            return Device::all();
        }
        else {
            return User::find($request->user()->user_id)->devices()->get();
        }
    }
}
