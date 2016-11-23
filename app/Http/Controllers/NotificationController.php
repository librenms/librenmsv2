<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @param null $type
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {

        $notifications = $this->api->be(auth()->user())->get('/api/notifications/'.$type);
        if ($type === 'archive') {
            $page = '';
            $button = 'Notifications';
            $bg = 'maroon';
        } else {
            $page = 'archive';
            $button = 'Archive';
            $bg = 'blue';
        }

        return view('notifications.list', compact(['notifications', 'page', 'button', 'bg', "type"]));
    }

    /**
     * Update a notifications status.
     *
     * @param $id
     * @param $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $action)
    {
        return response()->json($this->api->be(auth()->user())->patch('/api/notifications/'.$id.'/'.$action));
    }

    /**
     * Create a new notification
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:notifications|max:255',
            'body'  => 'required',
        ]);
        return response()->json($this->api->be(auth()->user())->put('/api/notifications', ['title' => $request->title, 'body' => $request->body]));
    }
}
