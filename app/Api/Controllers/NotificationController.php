<?php

namespace App\Api\Controllers;

use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use App\Notification;
use App\NotificationAttrib;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    use Helpers;

    public function __construct() {
    }

    /**
     * Display a listing of all notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type = null)
    {
        if ($type === 'archive')
        {
            $notifications = Notification::isarchived($request)->get();
        }
        else {
            $notifications = Notification::isunread()->get();
        }
        return $notifications;
    }

    public function update(Request $request, $id, $action)
    {
        if ($action === 'read' || $action === 'sticky')
        {
            if (NotificationAttrib::where('notifications_id', $id)->delete() >= 0)
            {
                $read = new NotificationAttrib;
                $read->notifications_id = $id;
                $read->user_id          = $request->user()->user_id;
                $read->key              = $action;
                $read->value            = 1;
                if ($read->save())
                {
                    return $this->response->array(array('statusText'=>'OK'));
                }
                else {
                    return $this->response->errorInternal();
                }
            }
        }
        elseif ($action === 'unread' || $action === 'unsticky')
        {
            if (NotificationAttrib::where('notifications_id', $id)->delete() >= 0)
            {
                return $this->response->array(array('statusText'=>'OK'));
            }
            else {
                return $this->response->errorInternal();
            }
        }
    }

}
