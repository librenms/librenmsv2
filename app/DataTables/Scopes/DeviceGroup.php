<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class DeviceGroup implements DataTableScopeContract {

    private $group_id;


    function __construct($group_id) {
        $this->group_id = $group_id;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->whereHas('groups', function ($q) {
            $q->where('id', '=', $this->group_id);
        });
    }
}