<?php

namespace App\Models\Alerting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class Alerts extends Model
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
    protected $table = 'alerts';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    // ---- Define Reletionships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rule()
    {
        return $this->belongsTo('App\Models\Alerting\Rules', 'rule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'devices_perms', 'device_id', 'user_id');
    }

    /**
     *
     */
     public function scopeActive(Builder $query)
     {
         return $query->where('state', '!=', '0');
     }
}
