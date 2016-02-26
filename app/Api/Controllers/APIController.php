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
    * Get info about the install
    */
    public function get_info() {
        $versions['git'] = `git rev-parse --short HEAD`;
        $versions['db_schema'] = DB::select('SELECT `version` FROM `dbSchema` LIMIT 1')[0]->version;
        return $versions;
    }

}
