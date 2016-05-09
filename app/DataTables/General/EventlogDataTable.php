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
use App\Models\General\Eventlog;

class EventlogDataTable extends BaseDataTable
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
            ->editColumn('device.hostname', function($eventlog) {
                $hostname = is_null($eventlog->device) ? trans('devices.text.deleted') : $eventlog->device->hostname;
                return '<a href="'.url("devices/".$eventlog->device_id).'">'.$hostname.'</a>';
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
        $eventlogs = Eventlog::with('device')->select('eventlog.*');
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
            'device.hostname' => [
                'title'       => trans('devices.label.hostname'),
            ],
            'type'      => [
                'title' => trans('general.text.type'),
                'name'  => 'eventlog.type',
            ],
            'message'   => [
                'title' => trans('general.text.message'),
            ],
            'datetime'  => [
                'title' => trans('general.text.timestamp'),
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
        return 'eventlog';
    }

    /**
     * Get ajax url.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getAjax()
    {
        return url('eventlog');
    }

}
