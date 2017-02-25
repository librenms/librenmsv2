<?php
/**
 * app/DataTables/General/ArpDataTable.php
 *
 * Datatable for arp search
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

namespace App\DataTables\General;

use App\DataTables\BaseDataTable;
use App\Models\General\IPv4;
use App\Models\General\IPv4Mac;

class ArpDataTable extends BaseDataTable
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
            ->editColumn('hostname', function ($data) {
                $hostname = is_null($data->device) ? trans('devices.text.deleted') : $data->device->hostname;
                return '<a href="'.url("devices/".$data->device_id).'">'.$hostname.'</a>';
            })
            ->editColumn('ifName', function ($data) {
                $ifName = is_null($data->ifName) ? trans('devices.text.deleted') : $data->ifName;
                return '<a href="'.url("devices/".$data->device_id."/ports/".$data->port_id).'">'.$ifName.'</a>';
            })
            ->addColumn('remote_device', function ($data) {
                $remote_device = IPv4::where('ipv4_addresses.ipv4_address', $data->ipv4_address)->with('port.device')->first();
                $remote_id = empty($remote_device->port->device->device_id) ? '' : $remote_device->port->device->device_id;
                $remote_hostname = empty($remote_device->port->device->hostname) ? '' : $remote_device->port->device->hostname;
                return '<a href="'.url("devices/".$remote_id).'">'.$remote_hostname.'</a>';
            })
            ->addColumn('remote_interface', function ($data) {
                $remote_device = IPv4::where('ipv4_addresses.ipv4_address', $data->ipv4_address)->with('port.device')->first();
                $remote_id = empty($remote_device->port->device->device_id) ? '' : $remote_device->port->device->device_id;
                $remote_port_id = empty($remote_device->port->port_id) ? '' : $remote_device->port->port_id;
                $remote_port = empty($remote_device->port->ifName) ? '' : $remote_device->port->ifName;
                return '<a href="'.url("devices/".$remote_id."/ports/".$remote_port_id).'">'.$remote_port.'</a>';
            })
            ->rawColumns(['hostname', 'ifName', 'remote_device', 'remote_interface'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $data = IPv4Mac::join('ports', 'ports.port_id', '=', 'ipv4_mac.port_id')->join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ipv4_mac.*', 'ports.*', 'devices.*');
        //FIXME We should use this once laravel-datatables supports it upstream $data = IPv4Mac::with('port.device')->select('ipv4_mac.*');
        return $this->applyScopes($data);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'hostname'  => [
                'title' => trans('devices.label.hostname'),
            ],
            'ifName'    => [
                'title' => trans('general.text.interface'),
            ],
            'mac_address' => [
                'title'   => trans('general.text.mac_address'),
            ],
            'ipv4_address' => [
                'title'    => trans('general.text.address'),
            ],
            'remote_device'  => [
                'searchable' => false,
            ],
            'remote_interface' => [
                'searchable'   => false,
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'arp';
    }
}
