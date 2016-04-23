<?php

namespace App\DataTables;

use App\Models\Alerting\Alerts;
use Yajra\Datatables\Services\DataTable;

class AlertsDataTable extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('state', '@if ($state == 0)
                                        <div class="label label-success">SUCCESS</div>
                                    @elseif ($state == 1)
                                        <div class="label label-danger">FAILED</div>
                                    @elseif ($state == 2)
                                        <div class="label label-warning">MUTED</div>
                                    @else
                                        <div class="label label-primary">UNKNOWN</div>
                                    @endif')
            ->editColumn('rule.name', function ($this) {
                return '<a href="' . url("alerting/rules/".$this['rule']['id']) . '">' . $this['rule']['name'] . '</a>';
            })
            ->editColumn('device.hostname', function ($this) {
                return '<a href="' . url("devices/".$this['device']['device_id']) . '">' . $this['device']['hostname'] . '</a>';
            })
            ->addColumn('actions', function ($this) {
                return '';
            })
            ->make(true);
            //            ->addColumn('action', 'path.to.action.view')
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $alerts = Alerts::query()->where('state', '!=', '0')->with('device')->with('user')->with('rule')->select('alerts.*');
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
                    //                    ->ajax('')
                    //                    ->addAction(['width' => '80px'])
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'state'     => [
                'title' => trans('alerting.alerts.text.state'),
            ],
            'rule.name' => [
                'title' => trans('alerting.alerts.text.rule'),
            ],
            'device.hostname' => [
                'title'       => trans('devices.label.hostname'),
            ],
            'timestamp',
            'rule.severity' => [
                'title'     => trans('alerting.alerts.text.severity'),
            ],
            'actions',
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
            'dom' => 'Blfrtip',
            'lengthMenu' => [[25, 50, 100, -1], [25, 50, 100, "All"]],
            'buttons' => [
                'csv', 'excel', 'pdf', 'print', 'reset', 'reload',
            ],
        ];
    }

}
