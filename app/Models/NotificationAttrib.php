<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NotificationAttrib
 *
 * @property integer $attrib_id
 * @property integer $notifications_id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Notification $notification
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NotificationAttrib whereAttribId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NotificationAttrib whereNotificationsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NotificationAttrib whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NotificationAttrib whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NotificationAttrib whereValue($value)
 * @mixin \Eloquent
 */
class NotificationAttrib extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications_attribs';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'attrib_id';

    // ---- Define Relationships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification()
    {
        return $this->belongsTo('App\Models\Notification', 'notifications_id');
    }
}
