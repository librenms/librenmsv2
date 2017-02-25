<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $realname
 * @property string $email
 * @property string $descr
 * @property boolean $level
 * @property boolean $can_modify_passwd
 * @property string $twofactor
 * @property integer $dashboard
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Port[] $ports
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dashboard[] $dashboards
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRealname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCanModifyPasswd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereTwofactor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDashboard($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'realname', 'username', 'password', 'email', 'level', 'descr',
    ];
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // ---- Helper Functions ----

    /**
     * Test if this user has global read access
     * these users have a level of 5, 10 or 11 (demo).
     *
     * @return boolean
     */
    public function hasGlobalRead()
    {
        return $this->isAdmin() || $this->level == 5;
    }

    /**
     * Test if the User is an admin or demo.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->level >= 10;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->user_id;
        // TODO: Implement getJWTIdentifier() method.
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return ['app' => 'LibreNMS', 'username' => $this->username];
    }

    // ---- Accessors/Mutators ----

    /**
     * Encrypt passwords before saving
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // ---- Define Relationships ----

    /**
     * Returns a list of devices this user has access to
     */
    public function devices()
    {
        return $this->belongsToMany('App\Models\Device', 'devices_perms', 'user_id', 'device_id');
    }

    /**
     * Returns a list of ports this user has access to
     */
    public function ports()
    {
        //FIXME we should return all ports for a device if the user has been given access to the whole device.
        return $this->belongsToMany('App\Models\Port', 'ports_perms', 'user_id', 'port_id');
    }

    /**
     * Returns a list of dashboards this user has
     */
    public function dashboards()
    {
        return $this->hasMany('App\Models\Dashboard', 'user_id');
    }
}
