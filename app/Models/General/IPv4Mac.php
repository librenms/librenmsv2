<?php
/**
 * app/Models/General/MAC.php
 *
 * Model for MAC Search
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
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\General\SearchIPv4
 *
 */
class IPv4Mac extends Model
{

    protected $hidden = array('ip');

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
    protected $table = 'ipv4_mac';
    /**
     * The primary key column name.
     *
     * @var string|bool
     */
    protected $primaryKey = false;
    /**
     * No incrementing primary key
     *
     * @var bool
     */
    public $incrementing = false;

    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the port this entry belongs to.
     */
    public function port()
    {
        return $this->belongsTo('App\Models\Port', 'port_id', 'port_id');
    }

    /**
     * Returns the device this entry belongs to.
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }

}
