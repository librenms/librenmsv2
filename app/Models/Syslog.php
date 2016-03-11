<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syslog extends Model
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
    protected $primaryKey = 'null';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the device this entry belongs to.
     */
    public function device() {
        return $this->belongsToOne('App\Models\Device', 'device_id', 'device_id');
    }

}
