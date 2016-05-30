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
use Settings;

class Bits extends BaseGraph
{

    public function png(Request $request)
    {
        return null;
    }

    public function buildRRDXport($input)
    {
        $rrd_path = Settings::get('rrd_dir');
        $hostname = $input->{'hostname'};
        $port = $input->{'port'};
        return "DEF:outoctets=$rrd_path/$hostname/port-$port.rrd:OUTOCTETS:AVERAGE \
                DEF:inoctets=$rrd_path/$hostname/port-$port.rrd:INOCTETS:AVERAGE \
                DEF:outoctets_max=$rrd_path/$hostname/port-$port.rrd:OUTOCTETS:MAX \
                DEF:inoctets_max=$rrd_path/$hostname/port-$port.rrd:INOCTETS:MAX \
                CDEF:octets=inoctets,outoctets,+ \
                CDEF:doutoctets=outoctets,-1,* \
                CDEF:outbits=outoctets,8,* \
                CDEF:outbits_max=outoctets_max,8,* \
                CDEF:doutoctets_max=outoctets_max,-1,* \
                CDEF:doutbits=doutoctets,8,* \
                CDEF:doutbits_max=doutoctets_max,8,* \
                CDEF:inbits=inoctets,8,* \
                CDEF:inbits_max=inoctets_max,8,* \
                CDEF:d95thoutn=doutbits,-1,* \
                XPORT:inbits:'In' \
                XPORT:inbits_max:'In Max' \
                XPORT:doutbits:'Out' \
                XPORT:doutbits_max:'Out Max'";
    }

    public function formatJson($index)
    {
        $data = [
            [
                'backgroundColor' => "rgba(3,205,86,1)",
                'borderColor' => "rgba(3,205,86,1)",
            ],
            [
                'backgroundColor' => "rgba(3,205,86,0.2)",
                'borderColor' => "rgba(3,205,86,0.2)",
            ],
            [
                'backgroundColor' => "rgba(96,96,144,1)",
                'borderColor' => "rgba(96,96,144,1)",
            ],
            [
                'backgroundColor' => "rgba(96,96,144,0.2)",
                'borderColor' => "rgba(96,96,144,0.2)",
            ],
        ];

        if (isset($data[$index]))
        {
            return $data[$index];
        }
        else
        {
            return [];
        }
    }

}
