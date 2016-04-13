<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
     * Test if the User is an admin or demo.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function isAdmin()
    {
        return $this->level >= 10;
    }

    /**
     * Test if this user has global read access
     * these users have a level of 5, 10 or 11 (demo).
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function hasGlobalRead()
    {
        return $this->isAdmin() || $this->level == 5;
    }


    // ---- Define Reletionships ----

    /**
     * Returns a list of devices this user has access to
     */
    public function devices() {
        return $this->belongsToMany('App\Models\Device', 'devices_perms', 'user_id', 'device_id');
    }

    /**
     * Returns a list of ports this user has access to
     */
    public function ports() {
        return $this->belongsToMany('App\Models\Port', 'ports_perms', 'user_id', 'port_id');
    }

    /**
     * Returns a list of dashboards this user has access to
     */
    public function dashboards() {
        return $this->hasMany('App\Models\Dashboard');
    }
}
