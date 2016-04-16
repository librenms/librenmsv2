<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersWidgets extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_widgets';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'user_widget_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['user_id', 'widget_id', 'col', 'row', 'size_x', 'size_y', 'title', 'refresh', 'settings', 'dashboard_id'];

}
