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

use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Device;
use Settings;

class BaseGraph
{

    private $type;
    private $input;
    private $device;

    /**
     * @param $value
     * @return $this
     */
    public function setType($value)
    {
        $this->type = $value;
        return $this;
    }

    /**
     * @param $input
     * @return $this
     */
    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @param $device
     * @return $this
     */
    public function setDevice($input)
    {
        $this->device = Device::find($input->device_id);
        return $this;
    }

    /**
     * @param $device
     * @return $this
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Get json output.
     *
     * @return array
     */
    public function json(Request $request)
    {
        $input = $this->input;
        if ($request->{'source'} === 'rrd')
        {
            $build = $this->buildRRDJson($input, $this->buildRRDXport($input));
        }
        $response = $this->runRRDXport($build['cmd']);
        return $this->parseRRDJson($response, $build['headers']);
    }

    /**
     * Get csv output.
     *
     * @return array
     */
    public function csv(Request $request)
    {
        $input = $this->input;
        if ($request->{'source'} === 'rrd') {
            $build = $this->buildRRDJson($input, $this->buildRRDXport($input));
            $response = $this->runRRDXport($build['cmd']);
            return $this->parseRRDCsv($response, $build['headers']);
        }
    }

    /**
     * Get png output.
     *
     * @return array
     */
    public function png(Request $request)
    {
        $input = $this->input;
        if ($request->{'source'} === 'rrd') {
            $build = $this->buildRRDGraph($input, $this->buildRRDGraphParams($input));
            $response = $this->runRRDGraph($build['cmd']);
            return base64_encode($response);
        }
    }

    /**
     * Build the RRD Xport query
     *
     * @return string
     */
    public function buildRRDJson($input, $setup) {
        $rrd_defs = $setup['defs'];
        $headers  = $setup['headers'];
        $cmd = build_rrdtool(' xport --json -s ' . $input->{'start'} . ' -e ' . $input->{'end'} . ' ' . $rrd_defs);

        return [
            'headers' => $headers,
            'cmd'     => $cmd,
        ];
    }

    /**
     * Build the RRD Graph command
     *
     * @return string
     */
    public function buildRRDGraph($input, $setup) {
        $rrd_defs = $setup['defs'];
        $headers = [];
        $cmd = build_rrdtool(' graph - -s ' . $input->{'start'} . ' -e ' . $input->{'end'} . ' ' .
            " --width " . $input->{'width'} . " --height " . $input->{'height'} . " --alt-autoscale-max --rigid -E -c BACK#EEEEEE00 -c SHADEA#EEEEEE00 -c SHADEB#EEEEEE00 -c \
                FONT#000000 -c CANVAS#FFFFFF00 -c GRID#a5a5a5 -c MGRID#FF9999 -c FRAME#5e5e5e -c ARROW#5e5e5e \
                -R normal --font LEGEND:8:DejaVuSansMono --font AXIS:7:DejaVuSansMono --font-render-mode normal " .
            $rrd_defs);
        return [
            'headers' => $headers,
            'cmd'     => $cmd,
        ];
    }

    /**
     * @param $cmd
     * @return mixed|string
     */
    public function runRRDGraph($cmd)
    {
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = $process->getOutput();
        return $output;
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
        $output = $process->getOutput();
        $output = preg_replace('/\'/', '"', $output);
        $output = preg_replace('/about\:/', '"meta":', $output);
        $output = preg_replace('/meta\:/', '"meta":', $output);
        $output = json_decode($output);
        return $output;
    }

    /**
     * Run the RRD Xport query
     *
     * @return string
     */
    public function parseRRDJson($response)
    {
        $step = $response->{'meta'}->{'step'};
        $start = $response->{'meta'}->{'start'};
        $end = $response->{'meta'}->{'end'};
        $cur_time = $start;
        $z = 0;
        $tmp_data = [];

        foreach ($response->{'data'} as $data)
        {
            $tmp_data['data'][$z][] = $cur_time + $step;
            foreach ($data as $key => $value)
            {
                $tmp_data['data'][$z][] = (is_null($value)) ? 0 : (int) $value;
            }
            //$tmp_data[] = $data;
            $z++;
        }
        $tmp_data['labels'] = ['x', 'A', 'B', 'C', 'D'];
        return json_encode($tmp_data);
    }

    /**
     * Parse RRD output to csv
     *
     * @return string
     */
    public function parseRRDCsv($response, $headers)
    {
        $step = $response->{'meta'}->{'step'};
        $start = $response->{'meta'}->{'start'};
        $end = $response->{'meta'}->{'end'};
        $cur_time = $start;
        $output = 'Date, ' . implode(',', $headers) . PHP_EOL;

        foreach ($response->{'data'} as $data)
        {
            $output .=  Carbon::createFromTimestamp($cur_time) . ',';
            $tmp_data = [];
            foreach ($data as $key => $value)
            {
                $tmp_data[] = (is_null($value)) ? 0 : (int) $value;
            }
            $output .= implode(',', $tmp_data) . PHP_EOL;
            $cur_time = $cur_time + $step;
        }
        return $output;
    }
}
