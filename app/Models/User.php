<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property string $username
 * @property string $realname
 * @property string $password
 * @property string $email
 * @property int $level
 * @property integer $user_id
 * @property string $descr
 * @property boolean $can_modify_passwd
 * @property string $twofactor
 * @property integer $dashboard
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'realname', 'username', 'password', 'email', 'level',
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


    // ---- Define Convience Functions ----

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


    // ---- Define Reletionships ----

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
        return $this->belongsToMany('App\Models\Port', 'ports_perms', 'user_id', 'port_id');
    }

    /**
     * Returns a list of dashboards this user has
     */
    public function dashboards()
    {
        return $this->hasMany('App\Models\Dashboard');
    }
}
