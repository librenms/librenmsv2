<?php
/**
 * WidgetDataController.php
 *
 * Provides data for widgets
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Api\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Settings;

class WidgetDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        switch ($id) {
            case 1:
                return $this->availabilityMap($request);

            default:
                return [];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


    private function availabilityMap(Request $request)
    {
        $uptime = Settings::get('uptime_warning', 84600);
        if ($request->user()->hasGlobalRead()) {
            $devices = Device::where('ignore', '=', 0)->get();
        } else {
            $devices = User::find($request->user()->user_id)->devices()->where('ignore', '=', 0)->get();
        }
        $counts = ['warn' => 0, 'up' => 0, 'down' => 0];
        foreach ($devices as $device) {
            if ($device->status == 1) {
                if (($device->uptime < $uptime) && ($device->uptime != '0')) {
                    $counts['warn']++;
                } else {
                    $counts['up']++;
                }
            } else {
                $counts['down']++;
            }
        }
        return compact(['devices', 'counts']);
    }
}
