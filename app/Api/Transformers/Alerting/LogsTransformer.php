<?php
/**
 * app/Api/Transformers/Alerting/LogsTransformer.php
 *
 * Transformer for alert log data
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

namespace App\Api\Transformers\Alerting;

use App\Models\Alerting\Log;
use League\Fractal;

class LogTransformer extends Fractal\TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param Notification $logs
     * @return array
     */
    public function transform(Log $logs)
    {
        return [
            'id'          => (int) $logs->id,
            'rule_id'     => (int) $logs->rule_id,
            'device_id'   => (int) $logs->device_id,
            'state'       => (int) $logs->state,
            'details'     => $logs->details,
            'time_logged' => $logs->time_logged,
        ];
    }
}
