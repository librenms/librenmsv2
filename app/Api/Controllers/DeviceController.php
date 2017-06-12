<?php

namespace App\Api\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Device resource representation.
 *
 * @Resource("Device", uri="/api/devices")
 */
class DeviceController extends Controller
{
    /**
     * Get a list of all devices
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request("/"),
     *      @Response(200, body={"devices":{{"id":34,"os":"linux","icon":"https://hostname/images/os/linux.svg","status":1,"uptime":423452},{"id":38,"os":"ios","icon":"https://hostname/images/os/cisco.svg","status":0,"uptime":452}}})
     * })
     * @Parameters({
     *      @Parameter("fields", type="sting", required=false, description="Comma separated list of fields to return"),
     *      @Parameter("per_page", type="integer", required=false, description="Pagination per-page count")
     * })
     */
    public function index(Request $request)
    {
        if ($request->user()->hasGlobalRead()) {
            $devices = Device::query();
        } else {
            $devices = $request->user()->devices();
        }

        $fields = isset($request->fields) ? explode(',', $request->fields) : ['*'];

        // paginate if requested (is this needed/documented?)
        if (isset($request->per_page)) {
            return $devices->paginate($request->per_page, $fields);
        }

        return $devices->get($fields);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Fetch a device
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request("/34"),
     *      @Response(200, body={"device":{"id":34,"os":"linux","icon":"https://hostname/images/os/linux.svg","status":1,"uptime":423452}})
     * })
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id of the device to show")
     * })
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->hasGlobalRead()) {
            $device = Device::find($id);
        } else {
            $user = User::find($request->user()->user_id);
            $device = $user->devices()->find($id);
        }
        // morph the data as required
        if ($request->query('displayFormat') == 'link') {
            return '<a href="'.url('/devices/').$device->deviceId.'">'.$device->hostname.'</a>';
        }

        return $device;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
