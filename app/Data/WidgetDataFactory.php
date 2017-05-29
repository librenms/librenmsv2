<?php
/**
 * WidgetDataFactory.php
 *
 * -Description-
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Data;

use App\Data\Interfaces\WidgetDataInterface;
use App\Data\Widgets\NullWidget;
use App\Models\Widgets;

class WidgetDataFactory
{
    /**
     * @param int $id The id from the widgets table
     * @return WidgetDataInterface
     */
    public static function createById($id)
    {
        $name = Widgets::find($id)->widget;
        $class = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
        $fqclass = 'App\Data\Widgets\\'.$class;

        if (class_exists($fqclass)) {
            return new $fqclass;
        }

        return new NullWidget();
    }
}
