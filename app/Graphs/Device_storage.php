<?php
/**
 * BaseGraph.php
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

namespace App\Graphs;

class Device_storage extends BaseGraph
{

    protected function buildRRDGraphParams()
    {
        //FIXME Add support for PNG Graph
        return [
            'headers' => '',
            'defs' => '',
        ];
    }

    protected function buildRRDXport()
    {

        if (isset($this->input->id) && is_numeric($this->input->id)) {
            $disk_ids = explode(',', $this->input->id);
            $disks = $this->device->storage()->whereIn('storage_id', $disk_ids)->get();
        } else {
            $disks = $this->device->storage()->get();
        }

        $headers = [];
        $defs = '';

        foreach ($disks as $disk) {
            $id = $disk->storage_id;
            $descr = rrdtool_escape($disk->storage_descr, 12);
            $headers[] = $descr;
            $rrd_file = rrd_name($this->device, array('storage', $disk->storage_mib, $disk->storage_descr));
            $defs .= "DEF:dsused$id=$rrd_file:used:AVERAGE \
                DEF:dsfree$id=$rrd_file:free:AVERAGE \
                CDEF:dssize$id=dsused$id,dsfree$id,+ \
                CDEF:dsperc$id=dsused$id,dssize$id,/,100,* \
                XPORT:dsperc$id:'$descr' ";
        }

        return [
            'headers' => $headers,
            'defs' => $defs,
        ];
    }
}
