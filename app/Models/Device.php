<?php

namespace App\Models;

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


    // ---- Accessors/Mutators ----

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

    public static function boot()
    {
        parent::boot();

        static::deleting(function(Device $device) {
            // delete related data
            $device->ports()->delete();
            $device->syslogs()->delete();
            $device->eventlogs()->delete();
        });
    }


    // ---- Define Reletionships ----

    /**
     * Returns a list of users that can access this device.
     */
    public function users() {
        return $this->belongsToMany('App\Models\User', 'devices_perms', 'device_id', 'user_id');
    }

    /**
     * Returns a list of the ports this device has.
     */
    public function ports() {
        return $this->hasMany('App\Models\Port', 'device_id', 'device_id');
    }

    /**
     * Returns a list of the Syslog entries this device has.
     */
    public function syslogs() {
        return $this->hasMany('App\Models\Syslog', 'device_id', 'device_id');
    }

    /**
     * Returns a list of the Eventlog entries this device has.
     */
    public function eventlogs() {
        return $this->hasMany('App\Models\Eventlog', 'device_id', 'device_id');
    }
}
