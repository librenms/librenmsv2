<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationAttrib
 *
 * @package App\Models
 * @property int $user_id
 * @property string $key
 * @property string $value
 */
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
