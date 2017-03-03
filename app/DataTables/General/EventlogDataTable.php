<?php
/**
 * app/DataTables/General/EventlogDataTable.php
 *
 * Datatable for eventlogs
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
use App\Models\Device;
use App\Models\General\Eventlog;

class EventlogDataTable extends BaseDataTable
{

    protected $device_id;

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('hostname', 'datatables.generic.hostname')
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
        if (is_numeric($this->device_id)) {
            // eventlogs for a single device
            $eventlogs = Device::find($this->device_id)->eventlogs()->select('eventlog.*');
        } else {
            $eventlogs = Eventlog::with([
                'device' => function ($query) {
                    return $query->addSelect(['device_id', 'hostname']);
                },
            ])->select('eventlog.*');
        }
        return $this->applyScopes($eventlogs);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'hostname' => [
                'title'     => trans('devices.label.hostname'),
                'orderable' => false,
            ],
            'type'     => [
                'title' => trans('general.text.type'),
                'name'  => 'eventlog.type',
            ],
            'message'  => [
                'title' => trans('general.text.message'),
            ],
            'datetime' => [
                'title' => trans('general.text.timestamp'),
            ],
        ];
    }

    /**
     * Sort by timestamp descending
     *
     * @return array
     */
    public function getBuilderParameters()
    {
        $params = parent::getBuilderParameters();
        $params['order'] = [[3, 'desc']];
        return $params;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'eventlog';
    }

    /**
     * Get ajax url.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getAjax()
    {
        return url('eventlog?device_id=' . $this->device_id);
    }

    public function forDevice($device_id)
    {
        $this->device_id = $device_id;
        return $this;
    }
}
