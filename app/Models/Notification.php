<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'notifications_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Mark this notifcation as read or unread
     *
     * @var bool
     */
    public function markRead($enabled) {
        $this->setAttrib('read', $enabled);
    }

    public function markSticky($enabled) {
        $this->setAttrib('sticky', $enabled);
    }

    /**
     * @param string $name
     */
    private function setAttrib($name, $enabled) {
        if ($enabled === true) {
            $read = new NotificationAttrib;
            $read->user_id          = \Auth::user()->user_id;
            $read->key              = $name;
            $read->value            = 1;

            return $this->attribs()->save($read);
        }
        else {
            return $this->attribs()->where('key', $name)->delete();
        }
    }


    public function scopeIsUnread($query)
    {
        return $query->leftJoin('notifications_attribs', 'notifications.notifications_id', '=', 'notifications_attribs.notifications_id')->source()->whereNull('notifications_attribs.user_id')->orWhere(['key'=>'sticky', 'value'=> 1])->limit();
    }

    public function scopeIsArchived($query, $request)
    {
        $user_id = $request->user()->user_id;
        return $query->leftJoin('notifications_attribs', 'notifications.notifications_id', '=', 'notifications_attribs.notifications_id')->source()->where('notifications_attribs.user_id', $user_id)->where(['key'=>'read', 'value'=> 1])->limit();
    }

    public function scopeLimit($query)
    {
        return $query->select('notifications.*', 'key', 'users.username');
    }

    public function scopeSource($query)
    {
        return $query->leftJoin('users', 'notifications.source', '=', 'users.user_id');
    }

    public function attribs() {
        return $this->hasMany('App\Models\NotificationAttrib', 'notifications_id', 'notifications_id');
    }

}
