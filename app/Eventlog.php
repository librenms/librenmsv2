<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventlog extends Model
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
    protected $primaryKey = 'event_id';

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
        return $this->belongsToOne('App\Device', 'device_id', 'host');
    }
}
