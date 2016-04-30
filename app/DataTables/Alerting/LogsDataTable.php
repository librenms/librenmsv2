<?php
/**
 * app/DataTables/Alerting/LogsDataTable.php
 *
 * Datatable for alert logs
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

namespace App\DataTables\Alerting;

use App\Models\Alerting\Log;
use Yajra\Datatables\Services\DataTable;

class LogsDataTable extends DataTable
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
            ->editColumn('device.hostname', function($log) {
                $hostname = is_null($log->device) ? trans('devices.text.deleted') : $log->device->hostname;
                return '<a href="'.url("devices/".$log->device_id).'">'.$hostname.'</a>';
            })
            ->editColumn('rule.name', function($log) {
                if ($log->rule_id) {
                    return '<a href="'.url("alerting/rules/".$log->rule_id).'">'.$log->rule->name.'</a>';
                }
                else {
                    return trans('alerting.general.text.invalid');
                }
            })
            ->editColumn('state', function($log) {
                $icon   = '';
                $colour = '';
                $text   = '';
                if ($log->state == 0) {
                    $icon   = 'check';
                    $colour = 'green';
                    $text   = trans('alerting.logs.text.ok');
                }
                elseif ($log->state == 1) {
                    $icon   = 'times';
                    $colour = 'red';
                    $text   = trans('alerting.logs.text.fail');
                }
                elseif ($log->state == 2) {
                    $icon   = 'volume-off';
                    $colour = 'lightgrey';
                    $text   = trans('alerting.logs.text.ack');
                }
                elseif ($log->state == 3) {
                    $icon   = 'arrow-down';
                    $colour = 'orange';
                    $text   = trans('alerting.logs.text.worse');
                }
                elseif ($log->state == 4) {
                    $icon   = 'arrow-up';
                    $colour = 'khaki';
                    $text   = trans('alerting.logs.text.better');
                }
                return '<b><span class="fa fa-'.$icon.'" style="color:'.$colour.'"></span> '.$text.'</b>';
            })
            ->editColumn('time_logged', function($log) {
                return date('Y-m-d H:i:s', $log->time_logged / 1000);
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
        $logs = Log::with('device', 'rule')->select('alert_log.*');
        return $this->applyScopes($logs);
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
            'rule.name' => [
                'title' => trans('alerting.general.text.rule'),
            ],
            'state'     => [
                'title' => trans('alerting.general.text.state'),
            ],
            'time_logged',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'logs';
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
            'order' => [3, 'desc'],
            'lengthMenu' => [[25, 50, 100, -1], [25, 50, 100, "All"]],
            'buttons' => [
                'csv', 'excel', 'pdf', 'print', 'reset', 'reload',
            ],
            'autoWidth' => false,
        ];
    }

}
