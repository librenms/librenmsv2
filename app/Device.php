<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'device_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getIpAttribute($ip)
    {
        if (!empty($ip)) {
            return inet_ntop($ip);
        }
    }

    public function setIpAttribute($ip)
    {
        $this->attributes['ip'] = inet_pton($ip);
    }

    // ---- Define Reletionships ----

    /**
     * Returns a list of users that can access this device.
     */
    public function users() {
        return $this->belongsToMany('App\User', 'devices_perms', 'device_id', 'user_id');
    }

    /**
     * Returns a list of the ports this device has.
     */
    public function ports() {
        return $this->hasMany('App\Port', 'device_id', 'device_id');
    }

}
