<?php
/**
 * app/Http/Controllers/Widgets/WidgetDataController.php
 *
 * HTTP Controller for Widgets data
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
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

namespace App\Http\Controllers\Widgets;

use App\DataTables\Alerting\AlertsDataTable;
use App\DataTables\General\EventlogDataTable;
use App\DataTables\General\SyslogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Port;
use App\Models\User;
use App\Settings;
use Illuminate\Http\Request;

class WidgetDataController extends Controller
{
    /**
     * Display the eventlog widget.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function eventlog(EventlogDataTable $dataTable)
    {
        return $dataTable->render('general.widget');
    }

    /**
     * Display the alerts widget.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function alerts(AlertsDataTable $dataTable)
    {
        return $dataTable->render('general.widget');
    }

    /**
     * Display the syslog widget.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function syslog(SyslogDataTable $dataTable)
    {
        return $dataTable->render('general.widget');
    }

    /**
     * Display the availability-map widget.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function Availability_Map(Settings $settings, Request $request)
    {
        $uptime = $settings->get('uptime_warning');
        if ($request->user()->hasGlobalRead())
        {
            $devices = Device::where('ignore', '=', 0)->get();
        }
        else
        {
            $devices = User::find($request->user()->user_id)->devices()->where('ignore', '=', 0)->get();
        }
        $count = ['warn' => 0, 'up' => 0, 'down' => 0];
        foreach ($devices as $device)
        {
            if ($device->status == 1)
            {
                if (($device->uptime < $uptime) && ($device->uptime != '0'))
                {
                    $count['warn']++;
                }
                else
                {
                    $count['up']++;
                }
            }
            else
            {
                $count['down']++;
            }
        }
        return view('widgets.availability-map', compact(['devices', 'uptime', 'count']));
    }

    /**
     * Display the device-summary widget.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function Device_Summary(Request $request)
    {
        $type = $request->route()->getAction()['type'];
        $count = [];
        if ($request->user()->hasGlobalRead())
        {
            $count['devices']['total']    = Device::all()->count();
            $count['devices']['up']       = Device::deviceup()->count();
            $count['devices']['down']     = Device::devicedown()->count();
            $count['devices']['ignored']  = Device::deviceignored()->count();
            $count['devices']['disabled'] = Device::devicedisabled()->count();

            $count['ports']['total']      = Port::portnotdeleted()->count();
            $count['ports']['up']         = Port::with('device')->portup()->count();
            $count['ports']['down']       = Port::with('device')->portdown()->count();
            $count['ports']['ignored']    = Port::with('device')->portignored()->count();
            $count['ports']['disabled']   = Port::with('device')->portdisabled()->count();
        }
        else
        {
            $count['devices']['total']    = User::find($request->user()->user_id)->devices()->count();
            $count['devices']['up']       = User::find($request->user()->user_id)->devices()->deviceup()->count();
            $count['devices']['down']     = User::find($request->user()->user_id)->devices()->devicedown()->count();
            $count['devices']['ignored']  = User::find($request->user()->user_id)->devices()->deviceignored()->count();
            $count['devices']['disabled'] = User::find($request->user()->user_id)->devices()->devicedisabled()->count();

            $count['ports']['total']      = User::find($request->user()->user_id)->ports()->with('device')->count();
            $count['ports']['up']         = User::find($request->user()->user_id)->ports()->with('device')->portup()->count();
            $count['ports']['down']       = User::find($request->user()->user_id)->ports()->with('device')->portdown()->count();
            $count['ports']['ignored']    = User::find($request->user()->user_id)->ports()->with('device')->portignored()->count();
            $count['ports']['disabled']   = User::find($request->user()->user_id)->ports()->with('device')->portdisabled()->count();
        }
        return view('widgets.device-summary', compact(['count', 'type']));
    }

    /**
     * Display the Worldmap widget.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function worldmap(Request $request)
    {
        return view('widgets.worldmap');
    }

}
