<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Dashboard
 *
 * @property integer $dashboard_id
 * @property integer $user_id
 * @property string $dashboard_name
 * @property integer $access
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UsersWidgets[] $widgets
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dashboard whereDashboardId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dashboard whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dashboard whereDashboardName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dashboard whereAccess($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dashboard allAvailable($user_id)
 * @mixin \Eloquent
 */
class Dashboard extends Model
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
    protected $table = 'dashboards';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'dashboard_id';
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
