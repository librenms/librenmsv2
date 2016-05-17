<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\General\Syslog
 *
 * @property integer $device_id
 * @property string $facility
 * @property string $priority
 * @property string $level
 * @property string $tag
 * @property string $timestamp
 * @property string $program
 * @property string $msg
 * @property integer $seq
 * @property-read \App\Models\Device $device
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereFacility($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog wherePriority($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereTag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereTimestamp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereProgram($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Syslog whereSeq($value)
 * @mixin \Eloquent
 */
class Syslog extends Model
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
    protected $table = 'syslog';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'seq';


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the device this entry belongs to.
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}
