<?php

namespace App\Models;

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


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Get the device this port belongs to.
     *
     */
    public function device() {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }

    /**
     * Returns a list of users that can access this port.
     */
    public function users() {
        return $this->belongsToMany('App\Models\User', 'ports_perms', 'port_id', 'user_id');
    }

}
