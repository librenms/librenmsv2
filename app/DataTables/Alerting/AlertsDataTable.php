<?php
/**
 * app/DataTables/Alerting/AlertsDataTable.php
 *
 * Datatable for alerts
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

use App\Models\Alerting\Alert;
use Yajra\Datatables\Services\DataTable;

class AlertsDataTable extends DataTable
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
            ->editColumn('id', '#{{ $id }}')
            ->editColumn('state', '@if ($state == 0)
                                        <div class="label label-success">SUCCESS</div>
                                    @elseif ($state == 1)
                                        <div class="label label-danger">FAILED</div>
                                    @elseif ($state == 2)
                                        <div class="label label-warning">MUTED</div>
                                    @else
                                        <div class="label label-primary">UNKNOWN</div>
                                    @endif')
            ->editColumn('rule.name', function($alert) {
                return '<a href="'.url("alerting/rules/".$alert->rule_id).'">'.$alert->rule->name.'</a>';
            })
            ->editColumn('device.hostname', function($alert) {
                $hostname = is_null($alert->device) ? trans('devices.text.deleted') : $alert->device->hostname;
                return '<a href="'.url("devices/".$alert->device_id).'">'.$hostname.'</a>';
            })
            ->addColumn('actions', function($alert) {
                if ($alert->state == 2) {
                    $btn  = "btn-danger";
                    $icon = "volume-off";
                }
                else {
                    $btn  = "btn-success";
                    $icon = "volume-up";
                }
                return '<a id="alerts-ack" data-id="'.$alert->id.'" data-state="'.$alert->state.'" class="btn btn-xs '.$btn.'"><i class="fa fa-'.$icon.' fa-fw"></i></a>';
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
        $alerts = Alert::with('device', 'rule')->active()->select('alerts.*');
        return $this->applyScopes($alerts);
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
            'id'        => [
                'title' => trans('alerting.alerts.text.id'),
            ],
            'state'     => [
                'title' => trans('alerting.general.text.state'),
            ],
            'rule.name' => [
                'title' => trans('alerting.general.text.rule'),
            ],
            'device.hostname' => [
                'title'       => trans('devices.label.hostname'),
            ],
            'timestamp',
            'rule.severity' => [
                'title'     => trans('alerting.alerts.text.severity'),
            ],
            'actions' => [
                'className' =>'alerts-ack',
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
        return 'alerts';
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
            'order' => [4, 'desc'],
            'lengthMenu' => [[25, 50, 100, -1], [25, 50, 100, "All"]],
            'buttons' => [
                'csv', 'excel', 'pdf', 'print', 'reset', 'reload',
            ],
            'autoWidth' => false,
        ];
    }

}
