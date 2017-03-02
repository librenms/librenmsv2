<?php
/**
 * app/DataTables/General/IPv4DataTable.php
 *
 * Datatable for ipv4 search
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

class IPv4DataTable extends BaseDataTable
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
            ->editColumn('hostname', 'datatables.generic.hostname')
            ->editColumn('ifName', function ($data) {
                $ifName = is_null($data->ifName) ? trans('devices.text.deleted') : $data->ifName;
                return '<a href="'.url("devices/".$data->device_id."/ports/".$data->port_id).'">'.$ifName.'</a>';
            })
            ->rawColumns(['hostname', 'ifName'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $data = IPv4::join('ports', 'ports.port_id', '=', 'ipv4_addresses.port_id')->join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ipv4_addresses.*', 'ports.*', 'devices.*');
        //FIXME We should use this once laravel-datatables supports it upstream $data = IPv4::with('port.device')->select('ipv4_addresses.*');
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
                'name'      => 'device.hostname',
                'title'     => trans('devices.label.hostname'),
                'orderable' => false,
            ],
            'ifName'    => [
                'title' => trans('general.text.interface'),
            ],
            'ipv4_address' => [
                'title'    => trans('general.text.address'),
            ],
            'ifDescr'   => [
                'title' => trans('general.text.port_descr'),
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
        return 'ipv4';
    }
}
