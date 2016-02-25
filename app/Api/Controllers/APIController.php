<?php

namespace App\Api\Controllers;

use DB;
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

    /**
    * Get info about the install
    */
    public function get_info() {
        $versions['git'] = `git rev-parse --short HEAD`;
        $versions['db_schema'] = DB::select('SELECT `version` FROM `dbSchema` LIMIT 1')[0]->version;
        return $versions;
    }

}
