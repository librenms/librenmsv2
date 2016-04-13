<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dashboards';

    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'dashboard_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function widgets() {
        return $this->hasMany('App\Models\UsersWidgets', 'dashboard_id');
    }

}
