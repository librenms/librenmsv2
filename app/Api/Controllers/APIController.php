<?php

namespace App\Api\Controllers;

use App\User;
use App\Device;
use App\Port;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct() {

    }

    /**
     * Get a list of devices
     */
    public function list_devices(Request $request) {
        if ($request->user()->level >= 10 || $request->user()->level == 5) {
            return Device::all();
        }
        else {
            return User::find($request->user()->user_id)->devices()->get();
        }
    }

    /**
     * Get a list of ports
     */
    public function list_ports(Request $request) {
        if ($request->user()->level >= 10 || $request->user()->level == 5) {
            return Port::all();
        }
        else {
            return User::find($request->user()->user_id)->ports()->get();
        }
    }
}
