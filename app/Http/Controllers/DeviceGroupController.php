<?php

namespace App\Http\Controllers;

use App\DataTables\DeviceGroupDataTable;
use App\Models\DeviceGroup;
use Illuminate\Http\Request;

use App\Http\Requests;

class DeviceGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DeviceGroupDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(DeviceGroupDataTable $dataTable)
    {
        return $dataTable->render('devices.group-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('devices.group-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = DeviceGroup::create($request->all());

        return response()->json(['message' => trans('devices.groups.created', ['name' => $group->name])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('devices/group='.$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = DeviceGroup::findOrFail($id);
        return view('devices.group-edit')->withGroup($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = DeviceGroup::find($id);
        $group->update($request->all());

        return response()->json(['message' => trans('devices.groups.updated', ['name' => $group->name])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = DeviceGroup::find($id);
        $group->delete();

        return response()->json(['message' => trans('devices.groups.deleted', ['name' => $group->name])]);
    }
}
