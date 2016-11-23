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

/**
 * App\Models\General\Inventory
 *
 * @property integer $entPhysical_id
 * @property integer $device_id
 * @property integer $entPhysicalIndex
 * @property string $entPhysicalDescr
 * @property string $entPhysicalClass
 * @property string $entPhysicalName
 * @property string $entPhysicalHardwareRev
 * @property string $entPhysicalFirmwareRev
 * @property string $entPhysicalSoftwareRev
 * @property string $entPhysicalAlias
 * @property string $entPhysicalAssetID
 * @property string $entPhysicalIsFRU
 * @property string $entPhysicalModelName
 * @property string $entPhysicalVendorType
 * @property string $entPhysicalSerialNum
 * @property integer $entPhysicalContainedIn
 * @property integer $entPhysicalParentRelPos
 * @property string $entPhysicalMfgName
 * @property integer $ifIndex
 * @property-read \App\Models\Device $device
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalHardwareRev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalFirmwareRev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalSoftwareRev($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalAssetID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalIsFRU($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalModelName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalVendorType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalSerialNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalContainedIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalParentRelPos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereEntPhysicalMfgName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\Inventory whereIfIndex($value)
 * @mixin \Eloquent
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


    // ---- Define Relationships ----

    /**
     * Returns the device this entry belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }
}
