<?php

namespace App\Models\Alerting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 *
 */
class Rules extends Model
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
    protected $table = 'alert_rules';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    // ---- Define Reletionships ----

}
