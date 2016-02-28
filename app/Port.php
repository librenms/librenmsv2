<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ports';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'port_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Selects what fields will be included when serializing this model
     *
     * @var array
     */
    protected $visible = ['device_id', 'device_name', 'ifAlias', 'ifSpeed', 'ifOutUcastPkts_delta', 'ifInUcastPkts_delta', 'ifType', 'ifDescr'];

    /**
     * Allows us to insert fields into the result when serializing
     *
     * @var array
     */
    protected $appends = ['device_name'];


    // ---- Accessors/Mutators ----

    /**
     * returns the name of the device this belongs to
     */
    public function getDeviceNameAttribute()
    {
        return $this->device()->first()->hostname;
    }

    // ---- Define Reletionships ----

    /**
     * Get the device this port belongs to.
     *
     */
    public function device() {
        return $this->belongsTo('App\Device', 'device_id', 'device_id');
    }

    /**
     * Returns a list of users that can access this port.
     */
    public function users() {
        return $this->belongsToMany('App\User', 'ports_perms', 'port_id', 'user_id');
    }

}
