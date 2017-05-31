<?php
/**
 * AvailabilityMap.php
 *
 * -Description-
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

namespace App\Data\Widgets;

use App\Data\Interfaces\WidgetDataInterface;
use App\Models\Device;
use Illuminate\Http\Request;
use Settings;

class AvailabilityMap implements WidgetDataInterface
{
    public function get(Request $request)
    {
        $user = $request->user();
        $uptime_warning = Settings::get('uptime_warning', 84600);

        if ($user->hasGlobalRead()) {
            $deviceQuery = Device::isNotIgnored();
        } else {
            $deviceQuery = $user->devices()->isNotIgnored();
        }
        $devices = $deviceQuery->get(['device_id', 'hostname', 'status', 'uptime']);

        $counts = $devices->reduce(function ($result, $device) use ($uptime_warning) {
            if ($device->status == 1) {
                if (($device->uptime < $uptime_warning) && ($device->uptime != '0')) {
                    $result['warn']++;
                } else {
                    $result['up']++;
                }
            } else {
                $result['down']++;
            }
            return $result;
        }, ['warn' => 0, 'up' => 0, 'down' => 0]);

        return compact(['devices', 'counts', 'uptime_warning']);
    }
}
