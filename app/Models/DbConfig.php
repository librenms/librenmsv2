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

use Illuminate\Database\Eloquent\Model;

/**
 * Class DbConfig
 *
 * @package App\Models
 */
class DbConfig extends Model
{
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

    public function scopeKey($query, $key)
    {
        return $query->where('config_name', 'LIKE', $key . '%');
    }

    public function scopeExactKey($query, $key)
    {
        return $query->where('config_name', $key);
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // ---- Accessors/Mutators ----

    public function getConfigValueAttribute($value)
    {
        if (!empty($value)) {
            return unserialize($value);
        }
        return $value;
    }

    public function setConfigValueAttribute($value)
    {
        $this->attributes['config_value'] = serialize($value);
    }
}
