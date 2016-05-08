<?php
/**
 * app/DataTables/General/SyslogDataTable.php
 *
 * Datatable for syslog
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
use App\Models\General\Syslog;

class SyslogDataTable extends BaseDataTable
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
            ->editColumn('device.hostname', function($syslog) {
                $hostname = is_null($syslog->device) ? trans('devices.text.deleted') : $syslog->device->hostname;
                return '<a href="'.url("devices/".$syslog->device_id).'">'.$hostname.'</a>';
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
        $syslog = Syslog::with('device')->select('syslog.*');
        return $this->applyScopes($syslog);
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
            'program'      => [
                'title' => trans('general.text.program'),
            ],
            'msg'   => [
                'title' => trans('general.text.message'),
            ],
            'timestamp'  => [
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
        return 'syslog';
    }

    /**
     * Get ajax url.
     *
     * @return string
     */
    public function getAjax()
    {
        return url('syslog');
    }

}
