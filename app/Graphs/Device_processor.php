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

class Device_processor extends BaseGraph
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
            $proc_ids = explode(',', $this->input->id);
            $procs = $this->device->processors()->whereIn('processor_id', $proc_ids)->get();
        } else {
            $procs = $this->device->processors()->get();
        }

        $headers = [];
        $defs = '';

        foreach ($procs as $proc) {
            $proc_descr = format_proc_descr($proc->processor_descr);
            $headers[] = $proc_descr;
            $id = $proc->hrDeviceIndex;
            $rrd_file = rrd_name($this->device, array('processor', 'hr', $id));
            $defs .= "DEF:ds$id=$rrd_file:usage:AVERAGE \
                XPORT:ds$id:'$proc_descr' ";
        }

        return [
            'headers' => $headers,
            'defs' => $defs,
        ];
    }
}
