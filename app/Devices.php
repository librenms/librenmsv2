<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    protected $table = 'devices';
    protected $primaryKey = 'device_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getIpAttribute( $ip )
    {
        if (!empty($ip)){
            return inet_ntop( $ip );
        }
    }

    public function setIpAttribute( $ip )
    {
        $this->attributes['ip'] = inet_pton( $ip );
    }

    // -- Define Reletionships --

    /**
     * Returns a list of users that can access this device
     */
    public function users() {
        return $this->belongsToMany('App\User', 'devices_perms', 'device_id', 'user_id');
    }
}
