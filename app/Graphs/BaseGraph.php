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
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Settings;

class BaseGraph
{

    private $type = '';

    public function setType($value)
    {
        $this->type = $value;
    }

    /**
     * Get json output.
     *
     * @return array
     */
    public function json(Request $request)
    {
        $input = json_decode($request->{'input'});
        if ($request->{'source'} == 'rrd-json')
        {
            $build = $this->buildRRDJson($input, $this->buildRRDXport($input));
        }
        $response = $this->runRRDXport($build);
        return $this->parseRRDJson($response);
    }

    /**
     * Get png output.
     *
     * @return array
     */
    public function png(Request $request)
    {
        return null;
    }

    /**
     * Build the RRD Xport query
     *
     * @return string
     */
    public function buildRRDJson($input, $rrd_params)
    {
        $cmd = Settings::get('rrdtool') . ' xport --json -s ' . $input->{'start'} . ' -e ' . $input->{'end'} . ' ' . $rrd_params;
        return $cmd;
    }

    /**
     * Run the RRD Xport query
     *
     * @return string
     */
    public function runRRDXport($query)
    {
        $process = new Process($query);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    /**
     * Run the RRD Xport query
     *
     * @return string
     */
    public function parseRRDJson($response)
    {
        $response = preg_replace('/\'/', '"', $response);
        $response = preg_replace('/about\:/', '"meta":', $response);
        $response = preg_replace('/meta\:/', '"meta":', $response);
        $response = json_decode($response);

        $step = $response->{'meta'}->{'step'};
        $start = $response->{'meta'}->{'start'};
        $end = $response->{'meta'}->{'end'};
        $cur_time = $start;
        $z=0;

        foreach ($response->{'data'} as $data)
        {
            $x=0;
            foreach ($data as $key => $value)
            {
                $tmp_data[$x][] = (is_null($value)) ? 0 : (int) $value;
                $x++;
            }
            $z++;
            $labels[] = date('Y-m-d', $cur_time);
            $cur_time = $cur_time + $step;
        }
        $y=0;
        foreach ($response->{'meta'}->{'legend'} as $legend)
        {
             $color = rand(0,255);
             $defaults = ['label' => $legend,
                            'data' => $tmp_data[$y],
                            'fill' => false,
                            'lineTension' => 0.1,
                            'backgroundColor' => "rgba($color,205,86,0.4)",
                            'borderColor' => "rgba($color,205,86,1)",
                            'pointRadius' => 1,
                            'pointBorderWidth' => 1,
                            'pointHoverRadius' => 4,
                            'pointHoverBackgroundColor' => "rgba($color,205,86,0.5)",
                            'pointHoverBorderColor' => "rgba($color,205,86,0.5)",
                            'pointHoverBorderWidth' => 1,
                        ];
                $out_data = $this->formatJson($y);

                $output['data'][$y] = array_merge($defaults,$out_data);
                $y++;
            }
        $output['labels'] = $labels;
        $output['tick'] = $this->getTick($this->type);
        return json_encode($output);
    }

    public function getTick($type)
    {
        switch ($type)
        {
            case 'bits':
                return 'BKMGT';
                break;
            default:
                return '';
                break;
        }
    }
}
