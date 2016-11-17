<?php
/**
 * RRD.php
 *
 * Fetch data from RRD files
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

use App\Exceptions\UnsupportedOutputFormatException;
use App\Models\Device;
use Settings;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

abstract class RRD implements Source
{
    /** @var array Array of formats this RRD Source supports */
    protected $supported_formats = [];

    /** @var string Holds the rrdtool command that will be run */
    protected $command;

    /**
     * RRD constructor.
     *
     * @param $args
     */
    public function __construct($args)
    {
        $this->command = $this->buildCommand($args);
    }

    /**
     * Run rrdtool and return the output
     *
     * @return string
     */
    protected function run()
    {
        $process = new Process($this->command);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    /**
     * Check if the requested format is supported
     *
     * @param $format
     * @return bool
     */
    protected function isFormatSupported($format)
    {
        return in_array($format, $this->supported_formats);
    }

    /**
     * Throw an exception if the requested format isn't supported
     *
     * @param $format
     * @throws UnsupportedOutputFormatException
     */
    protected function checkFormatSupported($format)
    {
        if (!$this->isFormatSupported($format)) {
            throw new UnsupportedOutputFormatException("Format ($format) is not supported by the chosen data source ".get_class($this));
        }
    }


    /**
     * Generate an rrdtool command with the supplied arguments
     *
     * @param string $args rrdtool arguments
     * @return string
     */
    private function buildCommand($args)
    {
        $rrd_cmd = Settings::get('rrdtool').' ';

        // if using rrdcached append --daemon and replace rrd_dir with rrdcached if it is set
        if (Settings::has('rrdcached')) {
            if (Settings::has('rrdcached_dir')) {
                $rrdcached_dir = Settings::get('rrdcached_dir');
                if ($rrdcached_dir !== false) {
                    $rrd_dir = Settings::get('rrd_dir');
                    $args = str_replace(array($rrd_dir.'/', $rrd_dir), './'.$rrdcached_dir.'/', $args);
                }
            }
            $rrdcached = Settings::get('rrdcached');
            $rrd_cmd .= "--daemon $rrdcached ";
        }
        return $rrd_cmd.$args;
    }

    /**
     * Generates a filename based on the hostname (or IP) and some extra items
     *
     * @param Device $device Device
     * @param array|string $extra Components of RRD filename - will be separated with "-", or a pre-formed rrdname
     * @param string $extension File extension (default is .rrd)
     * @return string the name of the rrd file for $host's $extra component
     */
    public static function getFileName($device, $extra, $extension = '.rrd')
    {
        $filename = safename(is_array($extra) ? implode("-", $extra) : $extra);
        return implode("/", array(Settings::get('rrd_dir'), $device->hostname, $filename.$extension));
    }

    /**
     * Get the name of this ports rrd file
     *
     * @param $port_id
     * @param string $suffix
     * @return string
     */
    public static function getPortName($port_id, $suffix = '')
    {
        if (!empty($suffix)) {
            $suffix = '-'.$suffix;
        }

        return "port-id$port_id$suffix";
    }

    /**
     * Get the full rrd path to this port on this device
     *
     * @param Device $device
     * @param $port_id
     * @param string $suffix
     * @return string
     */
    public static function getPortFileName($device, $port_id, $suffix = '')
    {
        return self::getFileName($device, self::getPortName($port_id, $suffix));
    }

    /**
     * Escapes strings for rrdtool
     *
     * @param string $string the string to escape
     * @param integer $length if passed, string will be padded and trimmed to exactly this length (after rrdtool unescapes it)
     * @return string
     */
    public static function escape($string, $length = null)
    {
        $result = shorten_interface_type($string);
        $result = str_replace("'", '', $result);            # remove quotes
        $result = str_replace('%', '%%', $result);          # double percent signs
        if (is_numeric($length) && strlen($string) > $length) {
            $extra = substr_count($string, ':', 0, $length);
            $result = substr(str_pad($result, $length), 0, ($length + $extra));
            if ($extra > 0) {
                $result = substr($result, 0, (-1 * $extra));
            }
        }

        $result = str_replace(':', '\:', $result);          # escape colons
        return $result.' ';
    }
}
