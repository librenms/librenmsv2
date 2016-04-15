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

    protected $fillable = ['user_id', 'dashboard_name', 'access'];

    public function widgets()
    {
        return $this->hasMany('App\Models\UsersWidgets', 'dashboard_id');
    }

    public function scopeAllAvailable($query, $user_id)
    {
        return $query->where('user_id', $user_id)
                    ->orWhere('access', '>', 0);
    }

}
