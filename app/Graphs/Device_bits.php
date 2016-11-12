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

use Illuminate\Http\Request;
use App\Models\Device;
use Settings;
use App\Models\Port;

class Device_bits extends BaseGraph
{

    public function buildRRDGraphParams($input) {
        $hostname = $input->{'hostname'};
        $port     = $input->{'port'};
        $filename = Settings::get('temp_dir') . '/' . str_random(10) . '.png';
        $output   = " $filename --alt-autoscale-max --rigid -E -c BACK#EEEEEE00 -c SHADEA#EEEEEE00 -c SHADEB#EEEEEE00 -c " .
                    "FONT#000000 -c CANVAS#FFFFFF00 -c GRID#a5a5a5 -c MGRID#FF9999 -c FRAME#5e5e5e -c ARROW#5e5e5e " .
                    "-R normal --font LEGEND:8:DejaVuSansMono --font AXIS:7:DejaVuSansMono --font-render-mode normal " .
                    "DEF:outoctets=/opt/librenms/rrd/$hostname/port-$port.rrd:OUTOCTETS:AVERAGE " .
                    "DEF:inoctets=/opt/librenms/rrd/$hostname/port-$port.rrd:INOCTETS:AVERAGE " .
                    "DEF:outoctets_max=/opt/librenms/rrd/$hostname/port-$port.rrd:OUTOCTETS:MAX " .
                    "DEF:inoctets_max=/opt/librenms/rrd/$hostname/port-$port.rrd:INOCTETS:MAX " .
                    "CDEF:octets=inoctets,outoctets,+ " .
                    "CDEF:doutoctets=outoctets,-1,* " .
                    "CDEF:outbits=outoctets,8,* " .
                    "CDEF:outbits_max=outoctets_max,8,* " .
                    "CDEF:doutoctets_max=outoctets_max,-1,* " .
                    "CDEF:doutbits=doutoctets,8,* " .
                    "CDEF:doutbits_max=doutoctets_max,8,* " .
                    "CDEF:inbits=inoctets,8,* " .
                    "CDEF:inbits_max=inoctets_max,8,* " .
                    "VDEF:totin=inoctets,TOTAL " .
                    "VDEF:totout=outoctets,TOTAL " .
                    "VDEF:tot=octets,TOTAL " .
                    "VDEF:95thin=inbits,95,PERCENT " .
                    "VDEF:95thout=outbits,95,PERCENT " .
                    "CDEF:d95thoutn=doutbits,-1,* " .
                    "VDEF:d95thoutn95=d95thoutn,95,PERCENT " .
                    "CDEF:d95thoutn95n=doutbits,doutbits,-,d95thoutn95,-1,*,+ " .
                    "VDEF:d95thout=d95thoutn95n,FIRST COMMENT:'bps Now Ave Max 95th %\n' " .
                    "AREA:inbits_max#D7FFC7: " .
                    "AREA:inbits#90B040: " .
                    "LINE:inbits#608720:'In ' " .
                    "GPRINT:inbits:LAST:%6.2lf%s " .
                    "GPRINT:inbits:AVERAGE:%6.2lf%s " .
                    "GPRINT:inbits_max:MAX:%6.2lf%s " .
                    "GPRINT:95thin:%6.2lf%s " .
                    "AREA:doutbits_max#E0E0FF: " .
                    "AREA:doutbits#8080C0: " .
                    "LINE:doutbits#606090:'Out' " .
                    "GPRINT:outbits:LAST:%6.2lf%s " .
                    "GPRINT:outbits:AVERAGE:%6.2lf%s " .
                    "GPRINT:outbits_max:MAX:%6.2lf%s " .
                    "GPRINT:95thout:%6.2lf%s " .
                    "GPRINT:tot:'Total %6.2lf%sB' " .
                    "GPRINT:totin:'(In %6.2lf%sB' " .
                    "GPRINT:totout:'Out %6.2lf%sB)\l' " .
                    "LINE1:95thin#aa0000 " .
                    "LINE1:d95thout#aa0000";
        return $output;
    }

    public function buildRRDXport($input)
    {
        $rrd_path = Settings::get('rrd_dir');
        $device_id = $input->{'device_id'};
        $device = Device::find($device_id);
        $hostname = $device->hostname;
        if (isset($input->id) && is_numeric($input->id)) {
            $port_ids = explode(',', $input->id);
            $ports = $device->ports()->whereIn('port_id', $port_ids)->get();
        } else {
            $ports = $device->ports()->get();
        }

        $headers = [];
        $defs = '';

        foreach ($ports as $port) {
            $headers[] = 'In: ' . $port['ifDescr'];
            $headers[] = 'Out: ' . $port['ifDescr'];
            $port_id = $port->port_id;
            $defs .= "DEF:outoct$port_id=$rrd_path/$hostname/port-id$port_id.rrd:OUTOCTETS:AVERAGE \
                DEF:inoct$port_id=$rrd_path/$hostname/port-id$port_id.rrd:INOCTETS:AVERAGE \
                CDEF:doutoct$port_id=outoct$port_id,-1,* \
                CDEF:doutbits$port_id=doutoct$port_id,8,* \
                CDEF:inbits$port_id=inoct$port_id,8,* \
                XPORT:inbits$port_id:'In' \
                XPORT:doutbits$port_id:'Out' ";
        }

        return [
            'headers' => $headers,
            'defs' => $defs,
        ];
    }
}
