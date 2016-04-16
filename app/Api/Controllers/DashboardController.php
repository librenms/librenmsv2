<?php

namespace App\Api\Controllers;

use Validator;
use App\Models\User;
use App\Models\Dashboard;
use App\Models\UsersWidgets;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    use Helpers;

    public function __construct() {

    }

    /**
     * Display a listing of all authorized devices
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dashboards = Dashboard::allAvailable($request->user())->get();
        return $dashboards;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'access' => 'required',
        ]);
        if($validation->passes())
        {
            $dashboard = new Dashboard;
            $dashboard->dashboard_name = $request->name;
            $dashboard->access         = $request->access;
            if ($request->user()->dashboards()->save($dashboard))
            {
                if (is_numeric($request->copy_from))
                {
                    $duplicate_widgets = Dashboard::find($request->copy_from)->widgets()->get();
                    foreach ($duplicate_widgets as $tmp_widget)
                    {
                        /** @var UsersWidgets $tmp_widget */
                        $new_widget               = $tmp_widget->replicate();
                        $new_widget->user_id      = $request->user()->user_id;
                        $new_widget->dashboard_id = $dashboard->dashboard_id;
                        unset($new_widget->user_widget_id);
                        $new_widget->save();
                    }
                }
                return $this->response->array(array('statusText' => 'OK', 'dashboard_id' => $dashboard->dashboard_id));
            }
            else {
                return $this->response->errorInternal();
            }
        }
        else {
            $errors = $validation->errors();
            return response()->json($errors,422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $dashboard = Dashboard::find($id);
        $widgets   = $dashboard->widgets()->get();
        // morph the data as required
        if ($request->query('displayFormat') == 'human') {
        }

        return array('dashboard' => $dashboard, 'widgets' => $widgets);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'access' => 'required',
        ]);
        if($validation->passes())
        {
            $dashboard = Dashboard::find($id);
            $dashboard->dashboard_name = $request->name;
            $dashboard->access         = $request->access;
            if ($dashboard->save())
            {
                return $this->response->array(array('statusText' => 'OK'));
            }
            else {
                return $this->response->errorInternal();
            }
        }
        else {
            $errors = $validation->errors();
            return response()->json($errors,422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (Dashboard::where('user_id', $request->user()->user_id)->where('dashboard_id', $id)->delete())
        {
            if (UsersWidgets::where('dashboard_id', $id)->delete() >= 0)
            {
                return $this->response->array(array('statusText' => 'OK'));
            }
            else {
                return $this->response->errorInternal();
            }
        }
        else {
            return $this->response->errorInternal();
        }
    }

    public function clear($id)
    {
        if (Dashboard::find($id)->widgets()->delete() >= 0)
        {
            return $this->response->array(array('statusText' => 'OK'));
        }
        else {
            return $this->response->errorInternal();
        }
    }

}
