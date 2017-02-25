<?php
/**
 * DeviceGroupDataTable.php
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
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\DataTables;

use App\Models\DeviceGroup;

class DeviceGroupDataTable extends BaseDataTable
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
            ->editColumn('name', 'datatables.device-group.link')
            ->editColumn('count', 'datatables.device-group.count')
            ->addColumn('actions', 'datatables.device-group.actions')
            ->rawColumns(['name', 'count', 'actions'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $devicegroups = DeviceGroup::with('deviceCountRelation')->select('device_groups.*');
        return $this->applyScopes($devicegroups);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'id'         => [
                'visible' => false,
            ],
            'name'       => [
                'title' => trans('devices.groups.name'),
            ],
            'count'      => [
                'title'      => '',
                'searchable' => false,
            ],
            'desc'       => [
                'title' => trans('devices.groups.desc'),
            ],
            'patternSql' => [
                'title' => trans('devices.groups.pattern'),
            ],
            'actions'    => [
                'title' => trans('devices.groups.actions'),
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
        return 'devicegroups';
    }
}
