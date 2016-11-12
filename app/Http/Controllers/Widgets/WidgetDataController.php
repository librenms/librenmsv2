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
use App\Models\UsersWidgets;
use Illuminate\Http\Request;
use Settings;

class WidgetDataController extends Controller
{
    /**
     * Display the eventlog widget.
     *
     * @param EventlogDataTable $EventlogDataTable
     * @param null $action
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function eventlog(EventlogDataTable $EventlogDataTable, $action = null)
    {
        $tableName = ['id' => 'eventlogDT'];
        return $EventlogDataTable->render('widgets.eventlog', compact(['tableName', 'action']));
    }

    /**
     * Display the alerts widget.
     *
     * @param AlertsDataTable $dataTable
     * @param null $action
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function alerts(AlertsDataTable $AlertsDataTable, $action = null)
    {
        $tableName = ['id' => 'alertlogDT'];
        return $AlertsDataTable->render('widgets.alertlog', compact(['tableName', 'action']));
    }

    /**
     * Display the syslog widget.
     *
     * @param SyslogDataTable $dataTable
     * @param null $action
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function syslog(SyslogDataTable $dataTable, $action = null)
    {
        $tableName = ['id' => 'syslogDT'];
        return $dataTable->render('widgets.syslog', compact(['tableName', 'action']));
    }

    /**
     * Display the availability-map widget.
     *
     * @param Request $request
     * @param string $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function availabilitymap(Request $request, $action = null)
    {
        $uptime = Settings::get('uptime_warning', 84600);
        if ($request->user()->hasGlobalRead()) {
            $devices = Device::where('ignore', '=', 0)->get();
        } else {
            $devices = User::find($request->user()->user_id)->devices()->where('ignore', '=', 0)->get();
        }
        $count = ['warn' => 0, 'up' => 0, 'down' => 0];
        foreach ($devices as $device) {
            if ($device->status == 1) {
                if (($device->uptime < $uptime) && ($device->uptime != '0')) {
                    $count['warn']++;
                } else {
                    $count['up']++;
                }
            } else {
                $count['down']++;
            }
        }
        $widget_settings = json_decode(UsersWidgets::getSettings($request)->value('settings'));
        return view('widgets.availability-map', compact(['devices', 'uptime', 'count', 'action', 'widget_settings']));
    }

    /**
     * Display the device-summary widget.
     *
     * @param Request $request
     * @param null $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function devicesummary(Request $request, $action = null)
    {
        $type = $request->route()->getAction()['type'];
        $count = [];
        if ($request->user()->hasGlobalRead()) {
            $count['devices']['total'] = Device::all()->count();
            $count['devices']['up'] = Device::isUp()->count();
            $count['devices']['down'] = Device::isDown()->count();
            $count['devices']['ignored'] = Device::isIgnored()->count();
            $count['devices']['disabled'] = Device::isDisabled()->count();

            $count['ports']['total'] = Port::notDeleted()->count();
            $count['ports']['up'] = Port::isUp()->count();
            $count['ports']['down'] = Port::isDown()->count();
            $count['ports']['ignored'] = Port::isIgnored()->count();
            $count['ports']['disabled'] = Port::isDisabled()->count();
        } else {
            $user = User::find($request->user()->user_id);

            $count['devices']['total'] = $user->devices()->count();
            $count['devices']['up'] = $user->devices()->isUp()->count();
            $count['devices']['down'] = $user->devices()->isDown()->count();
            $count['devices']['ignored'] = $user->devices()->isIgnored()->count();
            $count['devices']['disabled'] = $user->devices()->isDisabled()->count();

            $count['ports']['total'] = $user->ports()->count();
            $count['ports']['up'] = $user->ports()->isUp()->count();
            $count['ports']['down'] = $user->ports()->isDown()->count();
            $count['ports']['ignored'] = $user->ports()->isIgnored()->count();
            $count['ports']['disabled'] = $user->ports()->isDisabled()->count();
        }
        return view('widgets.device-summary', compact(['count', 'type', 'action']));
    }

    /**
     * Display the Worldmap widget.
     *
     * @param Request $request
     * @param null $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function worldmap(Request $request, $action = null)
    {
        return view('widgets.worldmap', compact(['action']));
    }

    /**
     * Display the notes widget.
     *
     * @param Request $request
     * @param string $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notes(Request $request, $action = null)
    {
        $widget_settings = json_decode(UsersWidgets::getSettings($request)->value('settings'));
        return view('widgets.notes', compact(['action', 'widget_settings']));
    }

    /**
     * Display the graph widget.
     *
     * @param string $action
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function graph(Settings $settings, Request $request, $action = null)
    {
        $div_id = mt_rand();
        $request->params = '{"content-type": "text/plain", "data-source": "rrd-csv"}';
        $params = json_decode($request->params);
        $widget_settings = json_decode(UsersWidgets::getSettings($request)->value('settings'));
        return view('widgets.graph', compact(['action', 'params', 'div_id']));
    }

}
