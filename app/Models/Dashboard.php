<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dashboard allAvailable($user)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'dashboard_name', 'access'];

    // ---- Define Reletionships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function widgets()
    {
        return $this->hasMany('App\Models\UsersWidgets', 'dashboard_id');
    }

    /**
     * @param Builder $query
     * @param $user_id
     * @return Builder|static
     */
    public function scopeAllAvailable(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id)
            ->orWhere('access', '>', 0);
    }
}
