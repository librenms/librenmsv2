<?php
/*
 * Copyright (C) 2016 Neil Lathwood <neil@lathwood.co.uk>
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

namespace App\Api\Transformers;

use App\Models\Alerting\Alerts;
use League\Fractal;

class AlertsTransformer extends Fractal\TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param Notification $alerts
     * @return array
     */
    public function transform(Alerts $alerts)
    {
        return [
            'id'        => (int)$alerts->id,
            'device_id' => $alerts->device_id,
            'rule_id'   => $alerts->rule_id,
            'state'     => $alerts->state,
            'alerted'   => $alerts->alerted,
            'open'      => $alerts->open,
            'timestamp' => $alerts->timestamp,
        ];
    }
}
