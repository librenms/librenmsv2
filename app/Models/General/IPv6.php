<?php
/**
 * app/Models/General/IPv6.php
 *
 * Model for IPv6 Search
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
 * App\Models\General\IPv6
 *
 * @property integer $ipv6_address_id
 * @property string $ipv6_address
 * @property string $ipv6_compressed
 * @property integer $ipv6_prefixlen
 * @property string $ipv6_origin
 * @property string $ipv6_network_id
 * @property integer $port_id
 * @property string $context_name
 * @property-read \App\Models\Port $port
 * @property-read \App\Models\Device $device
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereIpv6AddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereIpv6Address($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereIpv6Compressed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereIpv6Prefixlen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereIpv6Origin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereIpv6NetworkId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 wherePortId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\General\IPv6 whereContextName($value)
 * @mixin \Eloquent
 */
class IPv6 extends Model
{

    protected $hidden = ['ip'];

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
    protected $table = 'ipv6_addresses';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'ipv6_address_id';


    // ---- Accessors/Mutators ----


    // ---- Define Relationships ----

    /**
     * Returns the port this entry belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function port()
    {
        return $this->belongsTo('App\Models\Port', 'port_id', 'port_id');
    }

    /**
     * Returns the device this entry belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}
