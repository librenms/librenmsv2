<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Processor
 *
 * @property integer $processor_id
 * @property integer $device_id
 * @property-read \App\Models\Device $device
 * @mixin \Eloquent
 */
class Processor extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processors';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'processor_id';

    // ---- Define Helper Functions ----

    // ---- Accessors/Mutators ----


    // ---- Query scopes ----


    // ---- Define Relationships ----

    /**
     * Get the device this port belongs to.
     *
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}

