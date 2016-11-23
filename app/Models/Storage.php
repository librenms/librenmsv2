<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Storage
 *
 * @property integer $storage_id
 * @property integer $device_id
 * @property-read \App\Models\Device $device
 * @mixin \Eloquent
 * @property string $storage_mib
 * @property integer $storage_index
 * @property string $storage_type
 * @property string $storage_descr
 * @property integer $storage_size
 * @property integer $storage_units
 * @property integer $storage_used
 * @property integer $storage_free
 * @property integer $storage_perc
 * @property integer $storage_perc_warn
 * @property boolean $storage_deleted
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageMib($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageUnits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageUsed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageFree($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStoragePerc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStoragePercWarn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Storage whereStorageDeleted($value)
 */
class Storage extends Model
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
    protected $table = 'storage';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'storage_id';

    // ---- Helper Functions ----

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
