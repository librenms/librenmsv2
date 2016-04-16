<?php

namespace App\Api\Controllers;

use App\Models\Widgets;
use App\Models\Dashboard;
use App\Models\UsersWidgets;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class DashboardWidgetController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $row                         = Dashboard::find($request->dashboard_id)->widgets()->max('row')+1;
        $user_widget                 = new UsersWidgets;
        $user_widget->user_id        = $request->user()->user_id;
        $user_widget->widget_id      = $request->widget_id;
        $user_widget->col            = $request->col;
        $user_widget->row            = $row;
        $user_widget->size_x         = $request->size_x;
        $user_widget->size_y         = $request->size_y;
        $user_widget->title          = $request->title;
        $user_widget->dashboard_id   = $request->dashboard_id;
        if ($user_widget->save())
        {
            return $this->response->array(array('statusText' => 'OK', 'user_widget_id' => $user_widget->user_widget_id));
        }
        else {
            return $this->response->errorInternal();
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
        $widget  = Widgets::find($id);
        $content = $this->api->be(auth()->user())->get('/api/dashboard-widget/' . $id . '/content');
        return array('widget' => $widget, 'content' => $content);
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
        $users_widgets         = UsersWidgets::find($id);
        $users_widgets->col    = $request->input('x');
        $users_widgets->row    = $request->input('y');
        $users_widgets->size_x = $request->input('width');
        $users_widgets->size_y = $request->input('height');
        if ($users_widgets->save())
        {
            return $this->response->array(array('statusText' => 'OK'));
        }
        else {
            return $this->response->errorInternal();
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
        if (UsersWidgets::destroy($id))
        {
            return $this->response->array(array('statusText' => 'OK'));
        }
        else {
            return $this->response->errorInternal();
        }
    }

    public function get_content($id)
    {
        $content[] = 'Yes we have some text';
        return $this->response->array(array('statusText' => 'OK', 'content' => $content));
    }

    public function get_settings($id)
    {
        $settings = array('Yes we have some settings');
        return $this->response->array(array('statusText' => 'OK', 'content' => $settings));
    }

}
