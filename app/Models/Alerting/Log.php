<?php
/**
 * app/Models/Alerting/Log.php
 *
 * Model for access to alert log table data
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

namespace App\Models\Alerting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property integer $id
 * @property integer $device_id
 * @property integer $rule_id
 * @property integer $state
 * @property string $details
 * @property string $time_logged
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Alerting\Alert active()
 */
class Log extends Model
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
    protected $table = 'alert_log';
    /**
     * The primary key column name.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    // ---- Define Reletionships ----

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rule()
    {
        return $this->belongsTo('App\Models\Alerting\Rule', 'rule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'devices_perms', 'device_id', 'user_id');
    }

    // ---- Accessors/Mutators ----

    public function getDetailsAttribute($details)
    {
        if ($details) {
            return json_decode(gzuncompress($details), true);
        }
    }

    public function getTimeLoggedAttribute($date)
    {
        if ($date) {
            return strtotime($date)*1000;
        }
    }
}
