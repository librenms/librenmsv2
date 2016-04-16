<?php
/*
 * Copyright (C) 2016 Tony Murray <murraytony@gmail.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * DbConfig.php
 *
 * @package    LibreNMS
 * @author     Tony Murray <murraytony@gmail.com>
 * @copyright  2016 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DbConfig
 *
 * @package App\Models
 * @property integer $config_id
 * @property string $config_name
 * @property string $config_hidden
 * @property string $config_disabled
 * @property string $config_value
 * @property string $config_default
 * @property string $config_descr
 * @property string $config_group
 * @property integer $config_group_order
 * @property string $config_sub_group
 * @property integer $config_sub_group_order
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigHidden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigGroupOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigSubGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig whereConfigSubGroupOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig key($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DbConfig exactKey($key)
 * @mixin \Eloquent
 */
class DbConfig extends Model
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
    protected $table = 'config';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'config_id';
    /**
     * Define fillable fields
     *
     * @var array
     */
    protected $fillable = ['config_name', 'config_value'];

    // ---- Define Scopes ----

    /**
     * Limit the query to config_names that start with $key
     *
     * @param $query Builder
     * @param $key string The key (full or partial) to limit the query to.
     * @return Builder
     */
    public function scopeKey(Builder $query, $key)
    {
        return $query->where('config_name', 'LIKE', $key.'%');
    }

    /**
     * Limit the query to the exact config_name.
     *
     * @param $query Builder
     * @param $key string The full key to limit the query to.
     * @return Builder
     */
    public function scopeExactKey(Builder $query, $key)
    {
        return $query->where('config_name', $key);
    }

    // ---- Accessors/Mutators ----

    /**
     * Unserialize stored values.
     *
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function getConfigValueAttribute($value)
    {
        if (!empty($value)) {
            try {
                return unserialize($value);
            } catch (\Exception $e) {
                if (starts_with($e->getMessage(), 'unserialize():')) {
                    return $value;
                }
                else {
                    throw $e;
                }
            }
        }
        return $value;
    }

    /**
     * Serialize values before storing.
     *
     * @param $value
     */
    public function setConfigValueAttribute($value)
    {
        $this->attributes['config_value'] = serialize($value);
    }
}
