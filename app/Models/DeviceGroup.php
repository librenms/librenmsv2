<?php
/**
 * DeviceGroup.php
 *
 * Dynamic groups of devices
 *
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
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeviceGroup
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $pattern
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeviceGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeviceGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeviceGroup whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeviceGroup wherePattern($value)
 * @mixin \Eloquent
 */
class DeviceGroup extends Model
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
    protected $table = 'device_groups';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Virtual attributes
     *
     * @var string
     */
    protected $appends = ['deviceCount'];

    protected $fillable = ['name', 'desc', 'pattern'];

    /**
     * Fetch the device counts for groups
     * Use DeviceGroups::with('deviceCountRelation') to eager load
     *
     * @return int
     */
    public function getDeviceCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (!$this->relationLoaded('deviceCountRelation')) {
            $this->load('deviceCountRelation');
        }

        $related = $this->getRelation('deviceCountRelation')->first();

        // then return the count directly
        return ($related) ? (int)$related->count : 0;
    }


    // ---- Define Relationships ----

    /**
     * Relationship to App\Models\Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function devices()
    {
        return $this->belongsToMany('App\Models\Device', 'device_group_device', 'device_group_id', 'device_id');
    }

    /**
     * Relationship allows us to eager load device counts
     * DeviceGroups::with('deviceCountRelation')
     *
     * @return mixed
     */
    public function deviceCountRelation()
    {
        return $this->devices()->selectRaw('`device_group_device`.`device_group_id`, count(*) as count')->groupBy('pivot_device_group_id');
    }
}
