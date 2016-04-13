<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'widgets';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'widget_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
