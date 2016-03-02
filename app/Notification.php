<?php

namespace App;

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

    public function scopeUnread($query)
    {
        return $query->leftJoin('notifications_attribs', 'notifications.notifications_id', '=', 'notifications_attribs.notifications_id')->whereNull('user_id')->orWhere(['key'=>'sticky', 'value'=> 1])->limit();
    }

    public function scopeRead($query, $request)
    {
        $user_id = $request->user()->user_id;
        return $query->leftJoin('notifications_attribs', 'notifications.notifications_id', '=', 'notifications_attribs.notifications_id')->where('user_id', $user_id)->where(['key'=>'read', 'value'=> 1])->limit();
    }

    public function scopeLimit($query)
    {
        return $query->select('notifications.*','key');
    }

    public function users() {
        return $this->belongsToMany('App\User')->withPivot('notifications_id','user_id');
    }

}
