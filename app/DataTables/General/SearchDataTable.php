<?php
/**
 * app/DataTables/General/SearchDataTable.php
 *
 * Datatable for search
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

use App\Models\General\IPv4;
use App\Models\General\IPv4Mac;
use App\Models\General\IPv6;
use App\Models\Port;
use Yajra\Datatables\Services\DataTable;

class SearchDataTable extends DataTable
{

    protected $type;

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        if ($this->type !== "arp")
        {
            return $this->datatables
                ->eloquent($this->query())
                ->editColumn('hostname', function($data) {
                    $hostname = is_null($data->device) ? trans('devices.text.deleted') : $data->device->hostname;
                    return '<a href="'.url("devices/".$data->device_id).'">'.$hostname.'</a>';
                })
                ->editColumn('ifName', function($data) {
                    $ifName = is_null($data->ifName) ? trans('devices.text.deleted') : $data->ifName;
                    return '<a href="'.url("devices/".$data->device_id."/ports/".$data->port_id).'">'.$ifName.'</a>';
                })
                ->make(true);
        }
        else {
            return $this->datatables
                ->eloquent($this->query())
                ->editColumn('hostname', function($data) {
                    $hostname = is_null($data->device) ? trans('devices.text.deleted') : $data->device->hostname;
                    return '<a href="'.url("devices/".$data->device_id).'">'.$hostname.'</a>';
                })
                ->editColumn('ifName', function($data) {
                    $ifName = is_null($data->ifName) ? trans('devices.text.deleted') : $data->ifName;
                    return '<a href="'.url("devices/".$data->device_id."/ports/".$data->port_id).'">'.$ifName.'</a>';
                })
                ->addColumn('remote_device', function($data) {
                    $remote_device = IPv4::where('ipv4_addresses.ipv4_address', $data->ipv4_address)->with('port.device')->first();
                    $remote_id = empty($remote_device->port->device->device_id) ? '' : $remote_device->port->device->device_id;
                    $remote_hostname = empty($remote_device->port->device->hostname) ? trans('devices.text.deleted') : $remote_device->port->device->hostname;
                    return '<a href="'.url("devices/".$remote_id).'">'.$remote_hostname.'</a>';
                })
                ->addColumn('remote_interface', function($data) {
                    $remote_device = IPv4::where('ipv4_addresses.ipv4_address', $data->ipv4_address)->with('port.device')->first();
                    $remote_id = empty($remote_device->port->device->device_id) ? '' : $remote_device->port->device->device_id;
                    $remote_port_id = empty($remote_device->port->port_id) ? '' : $remote_device->port->port_id;
                    $remote_port = empty($remote_device->port->ifName) ? trans('devices.text.deleted') : $remote_device->port->ifName;
                    return '<a href="'.url("devices/".$remote_id."/ports/".$remote_port_id).'">'.$remote_port.'</a>';
                })
                ->make(true);
        }
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if ($this->type === "ipv4")
        {
            $data = IPv4::join('ports', 'ports.port_id', '=', 'ipv4_addresses.port_id')->join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ipv4_addresses.*', 'ports.*', 'devices.*');
            //FIXME We should use this once laravel-datatables supports it upstream $data = IPv4::with('port.device')->select('ipv4_addresses.*');
        }
        elseif ($this->type === "ipv6")
        {
            $data = IPv6::join('ports', 'ports.port_id', '=', 'ipv6_addresses.port_id')->join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ipv6_addresses.*', 'ports.*', 'devices.*');
            //FIXME We should use this once laravel-datatables supports it upstream $data = IPv6::with('port.device')->select('ipv6_addresses.*');
        }
        elseif ($this->type === "mac")
        {
            $data = Port::join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ports.*', 'devices.*');
            //FIXME This is valid but stops us generalising this file so until the nested queries above are fixed then we default to joins
            //$data = Port::with('device')->select('ports.*');
        }
        elseif ($this->type === "arp")
        {
            $data = IPv4Mac::join('ports', 'ports.port_id', '=', 'ipv4_mac.port_id')->join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ipv4_mac.*', 'ports.*', 'devices.*');
            //FIXME We should use this once laravel-datatables supports it upstream $data = IPv4Mac::with('port.device')->select('ipv4_mac.*');
        }
        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        $cols = [
            'hostname'  => [
                'title' => trans('devices.label.hostname'),
            ],
            'ifName'    => [
                'title' => trans('general.text.interface'),
            ],
        ];
        if ($this->type === "ipv4")
        {
            $cols = array_merge($cols, [
                'ipv4_address' => [
                    'title'    => trans('general.text.address'),
                ],
            ]);
        }
        if ($this->type === "ipv6")
        {
            $cols = array_merge($cols, [
                'ipv6_address' => [
                    'title'    => trans('general.text.address'),
                ],
            ]);
        }
        if ($this->type === "mac")
        {
            $cols = array_merge($cols, [
                'ifPhysAddress' => [
                    'title'    => trans('general.text.mac_address'),
                ],
            ]);
        }
        if ($this->type === "arp")
        {
            $cols = array_merge($cols, [
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
            ]);
        }
        if ($this->type !== "arp")
        {
            $cols = array_merge($cols, [
                'ifDescr'   => [
                    'title' => trans('general.text.port_descr'),
                ],
            ]);
        }
        return $cols;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'search';
    }

    /**
     * Get Builder Params
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'dom' => "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>".
                "<'row'<'col-sm-12'tr>>".
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'lengthMenu' => [[25, 50, 100, -1], [25, 50, 100, "All"]],
            'buttons' => [
                'csv', 'excel', 'pdf', 'print', 'reset', 'reload',
            ],
        ];
    }


    /**
     * @param string $type
     */
    public function forType($type)
    {
        $this->type = $type;
        return $this;
    }

}
