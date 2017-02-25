<?php
/**
 * app/DataTables/DeviceDataTable.php
 *
 * Datatable for devices
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

namespace App\DataTables;

use App\Models\Device;

class DeviceDataTable extends BaseDataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('status_reason', 'datatables.device.status-reason')
            ->editColumn('vendor', 'datatables.device.icon')
            ->editColumn('hostname', 'datatables.device.hostname')
            ->editColumn('resources', 'datatables.device.resources')
            ->editColumn('hardware', '{{ $hardware }}<br />{{ $features }}')
            ->editColumn('os', '{{ ucfirst($os) }}<br />{{ $version }}')
            ->editColumn('location', '{{ Util::formatUptime($uptime) }}<br />{{ $location }}')
            ->rawColumns(['status_reason', 'vendor', 'hostname', 'resources', 'hardware', 'os', 'location'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $device = Device::with(['portCountRelation', 'sensorCountRelation'])->select('devices.*');
        return $this->applyScopes($device);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'status'    => [
                'title' => trans('general.text.status'),
                'data'  => 'status_reason',
                'width' => '40px',
            ],
            'vendor'         => [
                'title'      => trans('devices.text.vendor'),
                'className'  => 'device-icon',
                'searchable' => false,
                'orderable'  => false,
            ],
            'hostname'  => [
                'title' => trans('devices.label.hostname'),
            ],
            'resources'      => [
                'title'      => '',
                'searchable' => false,
                'orderable'  => false,
            ],
            'hardware'  => [
                'title' => trans('devices.text.platform'),
            ],
            'features'    => [
                'visible' => false,
            ],
            'os'        => [
                'title' => trans('devices.text.os'),
            ],
            'version'     => [
                'visible' => false,
            ],
            'location'  => [
                'title' => trans('devices.text.uptime_location'),
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'devices';
    }
}
