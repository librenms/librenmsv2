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

namespace App\Api\Transformers;

use App\Models\Notification;
use League\Fractal;

class NotificationTransformer extends Fractal\TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param Notification $notification
     * @return array
     */
    public function transform(Notification $notification)
    {
        return [
            'id'       => (int) $notification->notifications_id,
            'title'    => $notification->title,
            'body'     => $notification->body,
            'source'   => $notification->source,
            'datetime' => $notification->datetime,
        ];
    }
}
