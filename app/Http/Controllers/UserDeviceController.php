<?php
/**
 * UserDeviceController.php
 *
 * Controls the user device relationship
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\AdminOnlyRequest;
use App\Models\Device;
use App\Models\User;

class UserDeviceController extends Controller
{
    public function create(AdminOnlyRequest $request, $user_id)
    {
        $user = User::with('devices')->find($user_id);

        return view('users.devices-create')->withUser($user);
    }

    /**
     * @param AdminOnlyRequest $request
     * @param $user_id
     * @return mixed
     */
    public function store(AdminOnlyRequest $request, $user_id)
    {
        $user = User::find($user_id);

        $device_ids = $request->input('devices');
        if (count($device_ids) == 0) {
            return redirect()->back();
        }

        foreach ($device_ids as $device_id) {
            $device = Device::find($device_id);
            $user->devices()->attach($device);
        }
        return redirect()->back()->with(['type' => 'success', 'message' => trans('user.text.devicesadded')]);
    }

    /**
     * @param AdminOnlyRequest $request
     * @param $user_id
     * @param $device_id
     * @return mixed
     */
    public function destroy(AdminOnlyRequest $request, $user_id, $device_id)
    {
        $user = User::find($user_id);
        $device = Device::find($device_id);
        $user->devices()->detach($device);
        return redirect()->back()->with(['type' => 'success', 'message' => trans('user.text.deviceremoved', ['hostname' => $device->hostname])]);
    }
}
