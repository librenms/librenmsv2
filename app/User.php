<?php

namespace App;

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

    // ---- Define Reletionships ----

    /**
     * Returns a list of devices this user has access to
     */
    public function devices() {
        return $this->belongsToMany('App\Devices', 'devices_perms', 'user_id', 'device_id');
    }

    /**
     * Returns a list of ports this user has access to
     */
    public function ports() {
        return $this->belongsToMany('App\Ports', 'ports_perms', 'user_id', 'port_id');
    }
}
