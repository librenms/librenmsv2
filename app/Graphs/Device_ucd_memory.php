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

class Device_ucd_memory extends BaseGraph
{

    public function buildRRDGraphParams($input) {
        //FIXME Add support for PNG Graph
        return [
            'headers' => '',
            'defs' => '',
        ];
    }

    public function buildRRDXport($input)
    {
        $rrd_path = Settings::get('rrd_dir');
        $device_id = $input->{'device_id'};
        $device = Device::find($device_id);
        $hostname = $device->hostname;

        $headers = ['RAM Used', '-Sh Bu Ca', 'RAM Free', 'Swap Used', 'Shared', 'Buffers', 'Cached'];
        $defs = "DEF:atotalswap=$rrd_path/$hostname/ucd_mem.rrd:totalswap:AVERAGE \
                 DEF:aavailswap=$rrd_path/$hostname/ucd_mem.rrd:availswap:AVERAGE \
                 DEF:atotalreal=$rrd_path/$hostname/ucd_mem.rrd:totalreal:AVERAGE \
                 DEF:aavailreal=$rrd_path/$hostname/ucd_mem.rrd:availreal:AVERAGE \
                 DEF:atotalfree=$rrd_path/$hostname/ucd_mem.rrd:totalfree:AVERAGE \
                 DEF:ashared=$rrd_path/$hostname/ucd_mem.rrd:shared:AVERAGE \
                 DEF:abuffered=$rrd_path/$hostname/ucd_mem.rrd:buffered:AVERAGE \
                 DEF:acached=$rrd_path/$hostname/ucd_mem.rrd:cached:AVERAGE \
                 CDEF:totalswap=atotalswap,1024,* \
                 CDEF:availswap=aavailswap,1024,* \
                 CDEF:totalreal=atotalreal,1024,* \
                 CDEF:availreal=aavailreal,1024,* \
                 CDEF:totalfree=atotalfree,1024,* \
                 CDEF:shared=ashared,1024,* \
                 CDEF:buffered=abuffered,1024,* \
                 CDEF:cached=acached,1024,* \
                 CDEF:usedreal=totalreal,availreal,- \
                 CDEF:usedswap=totalswap,availswap,- \
                 CDEF:trueused=usedreal,cached,buffered,shared,-,-,- \
                 CDEF:true_perc=trueused,totalreal,/,100,* \
                 CDEF:swrl_perc=usedswap,totalreal,/,100,* \
                 CDEF:swap_perc=usedswap,totalswap,/,100,* \
                 CDEF:real_perc=usedreal,totalreal,/,100,* \
                 CDEF:real_percf=100,real_perc,- \
                 CDEF:shared_perc=shared,totalreal,/,100,* \
                 CDEF:buffered_perc=buffered,totalreal,/,100,* \
                 CDEF:cached_perc=cached,totalreal,/,100,* \
                 CDEF:cusedswap=usedswap,-1,* \
                 CDEF:cdeftot=availreal,shared,buffered,usedreal,cached,usedswap,+,+,+,+,+ \
                 XPORT:usedreal:'Ram Used' \
                 XPORT:trueused:'-Sh, Bu, Ca' \
                 XPORT:availreal:'RAM Free' \
                 XPORT:usedswap:'Swap Used' \
                 XPORT:shared:'Shared' \
                 XPORT:buffered:'Buffers' \
                 XPORT:cached:'Cached'";
        return [
            'headers' => $headers,
            'defs' => $defs,
        ];
    }
}
