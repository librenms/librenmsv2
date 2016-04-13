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
        $dashboards = User::find($request->user()->user_id)->dashboards()->get();
        // morph the data as required
        if ($request->query('displayFormat') == 'human') {
        }

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
            $dashboard = new dashboard;
            $dashboard->user_id        = $request->user()->user_id;
            $dashboard->dashboard_name = $request->name;
            $dashboard->access         = $request->access;
            if ($dashboard->save())
            {
                if (is_numeric($request->copy_from))
                {
                    $duplicate_widgets = Dashboard::find($request->copy_from)->widgets()->get();
                    foreach ($duplicate_widgets as $new_widget)
                    {
                        UsersWidgets::create([  'user_id'      => $request->user()->user_id,
                                                'widget_id'    => $new_widget->widget_id,
                                                'col'          => $new_widget->col,
                                                'row'          => $new_widget->row,
                                                'size_y'       => $new_widget->size_y,
                                                'size_x'       => $new_widget->size_x,
                                                'title'        => $new_widget->title,
                                                'refresh'      => $new_widget->refresh,
                                                'settings'     => $new_widget->settings,
                                                'dashboard_id' => $dashboard->dashboard_id,
                                            ]);
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
        $widgets   = Dashboard::find($id)->widgets()->get();
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
    public function destroy($id)
    {
        if (Dashboard::destroy($id))
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
        if (UsersWidgets::where('dashboard_id', $id)->delete() >= 0)
        {
            return $this->response->array(array('statusText' => 'OK'));
        }
        else {
            return $this->response->errorInternal();
        }
    }

}
