<?php
/**
 * app/DataTables/General/InventoryDataTable.php
 *
 * Datatable for inventory
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

use App\Models\General\Inventory;
use Yajra\Datatables\Services\DataTable;

class InventoryDataTable extends DataTable
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
            ->editColumn('device.hostname', function($inventory) {
                $hostname = is_null($inventory->device) ? trans('devices.text.deleted') : $inventory->device->hostname;
                return '<a href="'.url("devices/".$inventory->device_id).'">'.$hostname.'</a>';
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $inventory = Inventory::with('device')->select('entPhysical.*');
        return $this->applyScopes($inventory);
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
        return [
            'device.hostname' => [
                'title'       => trans('devices.label.hostname'),
            ],
            'entPhysicalDescr'      => [
                'title' => trans('general.text.description'),
            ],
            'entPhysicalName'   => [
                'title' => trans('general.text.name'),
            ],
            'entPhysicalModelName'  => [
                'title' => trans('general.text.model'),
            ],
            'entPhysicalSerialNum'  => [
                'title' => trans('general.text.serial'),
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
        return 'inventory';
    }

    /**
     * Get Builder Params
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'dom' => 'Blfrtip',
            'lengthMenu' => [[25, 50, 100, -1], [25, 50, 100, "All"]],
            'buttons' => [
                'csv', 'excel', 'pdf', 'print', 'reset', 'reload',
            ],
        ];
    }

}
