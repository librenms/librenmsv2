<?php
/**
 * app/DataTables/General/MacDataTable.php
 *
 * Datatable for mac address search
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
use App\Models\Port;

class MacDataTable extends BaseDataTable
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
        $data = Port::join('devices', 'devices.device_id', '=', 'ports.device_id')->select('ports.*', 'devices.*');
        //FIXME This is valid but stops us generalising this file so until the nested queries above are fixed then we default to joins
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
            'ifPhysAddress' => [
                'title'    => trans('general.text.mac_address'),
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
        return 'mac';
    }
}
