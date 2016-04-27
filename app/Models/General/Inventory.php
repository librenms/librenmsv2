<?php
/**
 * app/Models/General/Inventory.php
 *
 * Model for inventory
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
 * App\Models\General\Inventory
 *
 */
class Inventory extends Model
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
    protected $table = 'entPhysical';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'entPhysical_id';


    // ---- Accessors/Mutators ----


    // ---- Define Reletionships ----

    /**
     * Returns the device this entry belongs to.
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }
}
