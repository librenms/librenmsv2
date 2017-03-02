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

use App\DataTables\BaseDataTable;
use App\Models\General\Inventory;

class InventoryDataTable extends BaseDataTable
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
            ->rawColumns(['hostname'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $inventory = Inventory::with([
            'device' => function ($query) {
                return $query->addSelect(['device_id', 'hostname']);
            },
        ])->select('entPhysical.*');
        return $this->applyScopes($inventory);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'hostname'             => [
                'title'     => trans('devices.label.hostname'),
                'orderable' => false,
            ],
            'entPhysicalDescr'     => [
                'title' => trans('general.text.description'),
            ],
            'entPhysicalName'      => [
                'title' => trans('general.text.name'),
            ],
            'entPhysicalModelName' => [
                'title' => trans('general.text.model'),
            ],
            'entPhysicalSerialNum' => [
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
}
