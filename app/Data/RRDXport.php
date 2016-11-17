<?php
/**
 * RRDXport.php
 *
 * -Description-
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
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Data;

use Cache;
use Carbon\Carbon;

class RRDXport extends RRD implements \JsonSerializable
{
    protected $supported_formats = ['json', 'csv'];
    private $headers;
    private $key;

    /**
     * RRDXport constructor.
     *
     * @param string $definition rrdtool definition
     * @param array $headers headers for rrdtool
     * @param string $start start time
     * @param string $end end time
     */
    public function __construct($definition, $headers, $start, $end)
    {
        $args = " xport --json -s $start -e $end $definition";
        parent::__construct($args);

        $this->headers = $headers;
        $this->key = $this->genKey('xport', $definition, implode(',', $headers), $this->roundTime($start), $this->roundTime($end));
    }

    /**
     * Return the output from this data source
     * May be base64 encoded PNG, Json Data, or CSV Data
     *
     * @param string $format png, json, or csv
     * @return string
     */
    public function fetch($format)
    {
        $this->checkFormatSupported($format);

        if ($format == 'json') {
            return $this->jsonSerialize();
        } elseif ($format == 'csv') {
            return $this->csvSerialize();
        }
        return null;  // shouldn't get here
    }

    /**
     * Get and cache the output of rrdtool as a json object
     *
     * @return mixed
     */
    private function getOutput()
    {
        return Cache::tags('graphs')->remember($this->key, 5, function () {
            $output = $this->run();
            $output = preg_replace('/\'/', '"', $output);
            $output = preg_replace('/about\:/', '"meta":', $output);
            $output = preg_replace('/meta\:/', '"meta":', $output);
            return json_decode($output);
        });
    }

    function jsonSerialize()
    {
        $response = $this->getOutput();
        $step = $response->meta->step;
        $start = $response->meta->start;
//        $end = $response->meta->end;
        $cur_time = $start;
        $tmp_data = [];

        foreach ($response->data as $data) {
            $tmp_data[] = [$cur_time] + array_map('intval', $data);
            $cur_time += $step;
        }

        return json_encode([
            'data'   => $tmp_data,
            'labels' => $this->headers,
        ]);
    }

    function csvSerialize()
    {
        $response = $this->getOutput();
        $step = $response->meta->step;
        $start = $response->meta->start;
//        $end = $response->meta->end;
        $cur_time = $start;
        $output = 'Date, '.implode(',', $this->headers).PHP_EOL;

        foreach ($response->data as $data) {
            $output .= Carbon::createFromTimestamp($cur_time).',';
            $output .= implode(',', array_map('intval', $data)).PHP_EOL;
            $cur_time += $step;
        }
        return $output;
    }
}
