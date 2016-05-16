<?php
/**
 * app/Api/Controllers/Alerting/LogsController.php
 *
 * API Controller for alerts log data
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

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RRDController extends Controller
{

    use Helpers;

    /**
     * Display a listing of all alerts
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $process = new Process('/opt/rrdtool/bin/rrdtool xport --start=-1y --end=-300 DEF:atotalswap=/opt/lnms/rrd/localhost/ucd_mem.rrd:totalswap:AVERAGE DEF:aavailswap=/opt/lnms/rrd/localhost/ucd_mem.rrd:availswap:AVERAGE DEF:atotalreal=/opt/lnms/rrd/localhost/ucd_mem.rrd:totalreal:AVERAGE DEF:aavailreal=/opt/lnms/rrd/localhost/ucd_mem.rrd:availreal:AVERAGE DEF:atotalfree=/opt/lnms/rrd/localhost/ucd_mem.rrd:totalfree:AVERAGE DEF:ashared=/opt/lnms/rrd/localhost/ucd_mem.rrd:shared:AVERAGE DEF:abuffered=/opt/lnms/rrd/localhost/ucd_mem.rrd:buffered:AVERAGE DEF:acached=/opt/lnms/rrd/localhost/ucd_mem.rrd:cached:AVERAGE CDEF:totalswap=atotalswap,1024,/ CDEF:availswap=aavailswap,1024,/ CDEF:totalreal=atotalreal,1024,/ CDEF:availreal=aavailreal,1024,/ CDEF:totalfree=atotalfree,1024,/ CDEF:shared=ashared,1024,/ CDEF:buffered=abuffered,1024,/ CDEF:cached=acached,1024,/ CDEF:usedreal=totalreal,availreal,- CDEF:usedswap=totalswap,availswap,- CDEF:trueused=usedreal,cached,buffered,shared,-,-,- CDEF:true_perc=trueused,totalreal,/,100,* CDEF:swrl_perc=usedswap,totalreal,/,100,* CDEF:swap_perc=usedswap,totalswap,/,100,* CDEF:real_perc=usedreal,totalreal,/,100,* CDEF:real_percf=100,real_perc,- CDEF:shared_perc=shared,totalreal,/,100,* CDEF:buffered_perc=buffered,totalreal,/,100,* CDEF:cached_perc=cached,totalreal,/,100,* CDEF:cusedswap=usedswap,-1,* CDEF:cdeftot=availreal,shared,buffered,usedreal,cached,usedswap,+,+,+,+,+ XPORT:usedreal:"RAM Used" XPORT:trueused:"-Sh,Bu,Ca" XPORT:availreal:"RAM Free" XPORT:cusedswap:"Swap used" XPORT:swap_perc:"% of RAM" XPORT:shared:"Shared" XPORT:buffered:"Buffered" XPORT:cached:"Cached" XPORT:totalreal:"Total" --json');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $run = json_decode($process->getOutput());

        $step = $run->{'meta'}->{'step'};
        $start = $run->{'meta'}->{'start'};
        $end = $run->{'meta'}->{'end'};
        $cur_time = $start+$step;
        $z=0;

        foreach ($run->{'data'} as $data)
        {
            $x=0;
            foreach ($data as $key => $value)
            {
                $tmp_data[$x][] = ['x' => $cur_time, 'y' => (is_null($value)) ? 0 : (int) $value];
                $x++;
            }
            $z++;
            $cur_time = $cur_time + $step;
        }
        $y=0;
        foreach ($run->{'meta'}->{'legend'} as $legend)
        {
            $output[$y] = ['name' => $legend,
                           'data' => $tmp_data[$y],
                           'start' => $run->{'meta'}->{'start'},
                           'end' => $run->{'meta'}->{'end'},
                           'step' => $run->{'meta'}->{'step'}];
            $y++;
        }
        return json_encode($output);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|null
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|null
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id, $action)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function destroy($id)
    {
        //
    }

}
