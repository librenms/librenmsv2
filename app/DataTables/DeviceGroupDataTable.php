<?php

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
            ->editColumn('name', function($group) {
                return '<a href="'.url('devices/group='.$group->id).'">'.$group->name.'</a>';
            })
            ->editColumn('count', function($group) {
                return '<span data-toggle="tooltip" title="'.$group->deviceCount.' '.trans('nav.devices.devices').'" class="badge bg-aqua">
                <i class="fa fa-server"></i>&nbsp; '.$group->deviceCount.'</span>';
            })
            ->addColumn('actions', function($group) {
                $edit = '<button type="button" class="btn btn-xs btn-primary showModal"  data-toggle="modal" data-target="#generalModal" data-href="'.
                    route('device-groups.edit', ['group_id' => $group->id]).
                    '"><i class="fa fa-edit fa-lg fa-fw"></i><span class="hidden-xs"> '.trans('button.edit').'</span></button> ';

                $delete = '<button type="button" class="btn btn-xs btn-danger deleteModal" data-toggle="modal" data-target="#deleteModal" data-href="'.
                    route('device-groups.destroy', ['group_id' => $group->id]).
                    '"><i class="fa fa-trash fa-lg fa-fw"></i><span class="hidden-xs"> '.trans('button.delete').'</span></button> ';

                return $edit.$delete;
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
        $devicegroups = DeviceGroup::with('deviceCountRelation');
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
            'id' => [
                'visible' => false,
            ],
            'name' => [
                'title' => trans('devices.groups.name'),
            ],
            'count'      => [
                'title'      => '',
                'searchable' => false,
            ],
            'desc' => [
                'title' => trans('devices.groups.desc'),
            ],
            'pattern' => [
                'title' => trans('devices.groups.pattern'),
            ],
            'actions' => [
                'title' => trans('devices.groups.actions'),
            ]
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