<?php

namespace App\Api\Controllers;

use App\Devices;
use App\User;
use App\DBSchema;
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

    public function get_info() {
        $dbschema = DBSchema::all()->first();
        return array('db_schema'=>$dbschema->version);
    }
}
