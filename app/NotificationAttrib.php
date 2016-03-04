<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationAttrib extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications_attribs';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'attrib_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
