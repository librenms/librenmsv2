<?php
/**
 * Bits.php
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

class Bits extends Graph
{
    protected function getRelation()
    {
        if ($this->hasIDs()) {
            return [
                'ports' => function (Builder $query) {
                    $query->whereIn('port_id', $this->getIDs());
                },
            ];
        }

        return 'ports';
    }

    protected function getData()
    {
        return $this->device->ports;
    }

    protected function getHeaders()
    {
        $headers = [];
        foreach ($this->getData() as $port) {
            $headers[] = 'In: '.$port['ifDescr'];
            $headers[] = 'Out: '.$port['ifDescr'];
        }
        return $headers;
    }

    protected function getRRDGraphDefinition()
    {
        $defs = " COMMENT:'              Now       Avg      Max' COMMENT:' \\n' ";

        foreach ($this->getData() as $port) {
            $port_id = $port->port_id;
            $rrd_file = RRD::getPortFileName($this->device, $port->port_id);
            $defs .= " DEF:outoctets$port_id=$rrd_file:OUTOCTETS:AVERAGE \
                DEF:inoctets$port_id=$rrd_file:INOCTETS:AVERAGE \
                DEF:outoctets_max$port_id=$rrd_file:OUTOCTETS:MAX \
                DEF:inoctets_max$port_id=$rrd_file:INOCTETS:MAX \
                CDEF:octets$port_id=inoctets$port_id,outoctets$port_id,+ \
                CDEF:doutoctets$port_id=outoctets$port_id,-1,* \
                CDEF:outbits$port_id=outoctets$port_id,8,* \
                CDEF:outbits_max$port_id=outoctets_max$port_id,8,* \
                CDEF:doutoctets_max$port_id=outoctets_max$port_id,-1,* \
                CDEF:doutbits$port_id=doutoctets$port_id,8,* \
                CDEF:doutbits_max$port_id=doutoctets_max$port_id,8,* \
                CDEF:inbits$port_id=inoctets$port_id,8,* \
                CDEF:inbits_max$port_id=inoctets_max$port_id,8,* \
                VDEF:totin$port_id=inoctets$port_id,TOTAL \
                VDEF:totout$port_id=outoctets$port_id,TOTAL \
                VDEF:tot$port_id=octets$port_id,TOTAL COMMENT:' \\n' \
                VDEF:95thin$port_id=inbits$port_id,95,PERCENT \
                VDEF:95thout$port_id=outbits$port_id,95,PERCENT \
                CDEF:d95thoutn$port_id=doutbits$port_id,-1,* \
                VDEF:d95thoutn95$port_id=d95thoutn$port_id,95,PERCENT \
                CDEF:d95thoutn95n$port_id=doutbits$port_id,doutbits$port_id,-,d95thoutn95$port_id,-1,*,+ \
                VDEF:d95thout$port_id=d95thoutn95n$port_id,FIRST  \
                AREA:inbits_max$port_id#D7FFC7: \
                AREA:inbits$port_id#90B040: \
                LINE:inbits$port_id#608720:'In ".str_pad($port['ifDescr'], 6)."' \
                GPRINT:inbits$port_id:LAST:%6.2lf%s \
                GPRINT:inbits$port_id:AVERAGE:%6.2lf%s \
                GPRINT:inbits_max$port_id:MAX:%6.2lf%s \
                AREA:doutbits_max$port_id#E0E0FF: \
                AREA:doutbits$port_id#8080C0:  COMMENT:' \\n' \
                LINE:doutbits$port_id#606090:'Out ' \
                GPRINT:outbits$port_id:LAST:%6.2lf%s \
                GPRINT:outbits$port_id:AVERAGE:%6.2lf%s \
                GPRINT:outbits_max$port_id:MAX:%6.2lf%s COMMENT:'\n' \
                LINE1:95thin$port_id#aa0000 \
                LINE1:d95thout$port_id#aa0000";
        }
        return $defs;
    }

    protected function getRRDXportDefinition()
    {
        $defs = '';
        foreach ($this->getData() as $port) {
            $port_id = $port->port_id;
            $rrd_file = RRD::getPortFileName($this->device, $port->port_id);
            $defs .= "DEF:outoctets$port_id=$rrd_file:OUTOCTETS:AVERAGE \
                DEF:inoctets$port_id=$rrd_file:INOCTETS:AVERAGE \
                CDEF:doutoctets$port_id=outoctets$port_id,-1,* \
                CDEF:doutbits$port_id=doutoctets$port_id,8,* \
                CDEF:inbits$port_id=inoctets$port_id,8,* \
                XPORT:inbits$port_id:'In' \
                XPORT:doutbits$port_id:'Out' ";
        }
        return $defs;
    }
}
