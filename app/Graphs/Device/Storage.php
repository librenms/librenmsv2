<?php
/**
 * Storage.php
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

class Storage extends Graph
{
    protected function getRelation()
    {
        if ($this->hasIDs()) {
            return [
                'storage' => function (Builder $query) {
                    $query->whereIn('storage_id', $this->getIDs());
                },
            ];
        }

        return 'storage';
    }

    protected function getData()
    {
        return $this->device->storage;
    }

    protected function getHeaders()
    {
        $headers = [];
        foreach ($this->getData() as $disk) {
            $headers[] = RRD::escape($disk->storage_descr, 12);
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
        foreach ($this->getData() as $disk) {
            $id = $disk->storage_id;
            $rrd_file = RRD::getFileName($this->device, array('storage', $disk->storage_mib, $disk->storage_descr));
            $defs .= "DEF:dsused$id=$rrd_file:used:AVERAGE \
                DEF:dsfree$id=$rrd_file:free:AVERAGE \
                CDEF:dssize$id=dsused$id,dsfree$id,+ \
                CDEF:dsperc$id=dsused$id,dssize$id,/,100,* \
                XPORT:dsperc$id:'".RRD::escape($disk->storage_descr, 12)."' ";
        }
        return $defs;
    }
}
