<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Sensor
 *
 * @property integer $sensor_id
 * @property boolean $sensor_deleted
 * @property string $sensor_class
 * @property integer $device_id
 * @property string $poller_type
 * @property string $sensor_oid
 * @property string $sensor_index
 * @property string $sensor_type
 * @property string $sensor_descr
 * @property integer $sensor_divisor
 * @property integer $sensor_multiplier
 * @property float $sensor_current
 * @property float $sensor_limit
 * @property float $sensor_limit_warn
 * @property float $sensor_limit_low
 * @property float $sensor_limit_low_warn
 * @property boolean $sensor_alert
 * @property string $sensor_custom
 * @property string $entPhysicalIndex
 * @property string $entPhysicalIndex_measured
 * @property string $lastupdate
 * @property float $sensor_prev
 * @property-read \App\Models\Device $device
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor wherePollerType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorOid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorDivisor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorMultiplier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorCurrent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorLimitWarn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorLimitLow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorLimitLowWarn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorAlert($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorCustom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereEntPhysicalIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereEntPhysicalIndexMeasured($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereLastupdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sensor whereSensorPrev($value)
 * @mixin \Eloquent
 */
class Sensor extends Model
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
    protected $table = 'sensors';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'sensors_id';

    // ---- Define Reletionships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }

}
