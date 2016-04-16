<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Notification
 *
 * @property integer $notifications_id
 * @property string $title
 * @property string $body
 * @property string $source
 * @property string $checksum
 * @property string $datetime
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationAttrib[] $attribs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereNotificationsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereChecksum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereDatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification isUnread()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification isArchived($request)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification limit()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification source()
 * @mixin \Eloquent
 */
class Notification extends Model
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
    protected $table = 'notifications';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'notifications_id';

    // ---- Define Convenience Functions ---

    /**
     * Mark this notifcation as read or unread
     *
     * @var bool
     */
    public function markRead($enabled)
    {
        $this->setAttrib('read', $enabled);
    }

    /**
     * @param string $name
     * @return Model
     */
    private function setAttrib($name, $enabled)
    {
        if ($enabled === true) {
            $read = new NotificationAttrib;
            $read->user_id = \Auth::user()->user_id;
            $read->key = $name;
            $read->value = 1;

            return $this->attribs()->save($read);
        }
        else {
            return $this->attribs()->where('key', $name)->delete();
        }
    }

    public function attribs()
    {
        return $this->hasMany('App\Models\NotificationAttrib', 'notifications_id', 'notifications_id');
    }

    public function markSticky($enabled)
    {
        $this->setAttrib('sticky', $enabled);
    }

    // ---- Define Scopes ----

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeIsUnread(Builder $query)
    {
        return $query->leftJoin('notifications_attribs', 'notifications.notifications_id', '=', 'notifications_attribs.notifications_id')->source()->whereNull('notifications_attribs.user_id')->orWhere(['key' => 'sticky', 'value' => 1])->limit();
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return mixed
     */
    public function scopeIsArchived(Builder $query, User $user)
    {
        $user_id = $user->user_id;
        return $query->leftJoin('notifications_attribs', 'notifications.notifications_id', '=', 'notifications_attribs.notifications_id')->source()->where('notifications_attribs.user_id', $user_id)->where(['key' => 'read', 'value' => 1])->limit();
    }

    /**
     * @param Builder $query
     * @return $this
     */
    public function scopeLimit(Builder $query)
    {
        return $query->select('notifications.*', 'key', 'users.username');
    }

    /**
     * @param Builder $query
     * @return Builder|static
     */
    public function scopeSource(Builder $query)
    {
        return $query->leftJoin('users', 'notifications.source', '=', 'users.user_id');
    }

}
