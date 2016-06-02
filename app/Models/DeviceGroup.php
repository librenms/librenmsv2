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
}
