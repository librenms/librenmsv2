<?php
/**
 * Processor.php
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

namespace App\Graphs\Device;

use App\Data\RRD;
use App\Graphs\Graph;
use Illuminate\Database\Query\Builder;

class Processor extends Graph
{
    protected function getRelation()
    {
        if ($this->hasIDs()) {
            return [
                'processors' => function (Builder $query) {
                    $query->whereIn('processor_id', $this->getIDs());
                },
            ];
        }

        return 'processors';
    }

    protected function getData()
    {
        return $this->device->processors;
    }

    protected function getHeaders()
    {
        $headers = [];
        foreach ($this->getData() as $proc) {
            $headers[] = $proc->getFormattedDescription();
        }
        return $headers;
    }

    protected function getRRDGraphDefinition()
    {
        // TODO: Implement getRRDGraphDefinition() method.
    }

    protected function getRRDXportDefinition()
    {
        $defs = '';
        foreach ($this->getData() as $proc) {
            /** @var \App\Models\Processor $proc */
            $id = $proc->hrDeviceIndex;
            $rrd_file = RRD::getFileName($this->device, array('processor', 'hr', $id));
            $defs .= "DEF:ds$id=$rrd_file:usage:AVERAGE \
                XPORT:ds$id:'".$proc->getFormattedDescription()."' ";
        }
        return $defs;
    }
}
