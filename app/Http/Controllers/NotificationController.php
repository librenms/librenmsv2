<?php

namespace App\Http\Controllers;

use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use Helpers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {

        $notifications = $this->api->be(auth()->user())->get('/api/notifications/'.$type);
        if ($type === 'archive')
        {
            $page   = '';
            $button = ' notifications';
            $bg     = 'maroon';
        }
        else {
            $page   = 'archive';
            $button = ' archive';
            $bg     = 'blue';
        }

        return view('notifications.list', ['notifications' => $notifications, 'page' => $page, 'button' => $button, 'bg' => $bg, "type" => $type]);
    }

    public function update($id, $action)
    {

        return response()->json($this->api->be(auth()->user())->patch('/api/notifications/'.$id.'/'.$action));
    }

}
