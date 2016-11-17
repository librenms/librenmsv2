<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Service
 *
 * @property integer $service_id
 * @property integer $device_id
 * @property string $service_ip
 * @property string $service_type
 * @property string $service_desc
 * @property string $service_param
 * @property integer $service_ignore
 * @property integer $service_status
 * @property integer $service_changed
 * @property string $service_message
 * @property integer $service_disabled
 * @property string $service_ds
 * @property-read \App\Models\Device $device
 * @mixin \Eloquent
 */
class Service extends Model
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
    protected $table = 'services';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'service_id';

    // ---- Define Reletionships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }

}
