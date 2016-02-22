<?php

namespace App\Api\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct() {

    }

    public function list_devices(Request $request) {
        if ($request->user()->level >= 10 || $request->user()->level == 5) {
            $tmp_devices = DB::table('devices')
                ->select(DB::raw('DISTINCT(`devices`.`device_id`),`devices`.*'))
                ->get();
        }
        else {
             $tmp_devices = DB::table('devices')
                ->select(DB::raw('DISTINCT(`devices`.`device_id`),`devices`.*'))
                ->leftJoin('devices_perms AS DP', 'devices.device_id', '=', 'DP.device_id')
                ->where('DP.user_id', '=', $request->user()->user_id)
                ->get();
        }

        foreach ($tmp_devices as $device) {
            if ($device->status == 0) {
                $visual_status = 'danger';
                $msg           = $device->status_reason;
            }
            else {
                $visual_status = 'success';
                $msg           = 'up';
            }
            $device->{'visual_status'} = '<span class="label label-'.$visual_status.'">'.$msg.'</span>';
            $devices[] = $device;
        }

        return $devices;
    }
}
