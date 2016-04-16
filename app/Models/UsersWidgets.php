<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UsersWidgets
 *
 * @property integer $user_widget_id
 * @property integer $user_id
 * @property integer $widget_id
 * @property boolean $col
 * @property boolean $row
 * @property boolean $size_x
 * @property boolean $size_y
 * @property string $title
 * @property boolean $refresh
 * @property string $settings
 * @property integer $dashboard_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereUserWidgetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereWidgetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereCol($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereRow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereSizeX($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereSizeY($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereRefresh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereSettings($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersWidgets whereDashboardId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Widgets $widget
 * @property-read \App\Models\Dashboard $dashboard
 */
class UsersWidgets extends Model
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
    protected $table = 'users_widgets';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'user_widget_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'widget_id', 'col', 'row', 'size_x', 'size_y', 'title', 'refresh', 'settings', 'dashboard_id'];

    // ---- Define Relationships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function widget()
    {
        return $this->hasOne('App\Models\Widgets', 'widget_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dashboard()
    {
        return $this->belongsTo('App\Models\Dashboard', 'dashboard_id');
    }

}
