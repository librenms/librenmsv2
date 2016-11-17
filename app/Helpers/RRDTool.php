<?php
use App\Models\Device;

/**
 * Generates a filename based on the hostname (or IP) and some extra items
 *
 * @param Device $device Device
 * @param array|string $extra Components of RRD filename - will be separated with "-", or a pre-formed rrdname
 * @param string $extension File extension (default is .rrd)
 * @return string the name of the rrd file for $host's $extra component
 */
function rrd_name($device, $extra, $extension = '.rrd')
{
    $filename = safename(is_array($extra) ? implode("-", $extra) : $extra);
    return implode("/", array(Settings::get('rrd_dir'), $device->hostname, $filename.$extension));
}

/**
 * Escapes strings for RRDtool
 *
 * @param string $string the string to escape
 * @param integer $length if passed, string will be padded and trimmed to exactly this length (after rrdtool unescapes it)
 * @return string
 */
function rrdtool_escape($string, $length = null)
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
} // rrdtool_escape

function build_rrdtool($arg)
{
    $rrdtool       = Settings::get('rrdtool');
    $rrdcached     = Settings::get('rrdcached');
    $rrdcached_dir = Settings::get('rrdcached_dir');
    $rrd_dir       = Settings::get('rrd_dir');
    $rrd_daemon    = '';
    if (isset($rrdcached)) {
        if (isset($rrdcached_dir) && $rrdcached_dir !== false) {
            $arg = str_replace($rrd_dir.'/', './'.$rrdcached_dir.'/', $arg);
            $arg = str_replace($rrd_dir, './'.$rrdcached_dir.'/', $arg);
        }
        $rrd_daemon = " --daemon $rrdcached ";
    }
    return $rrdtool . ' ' . $rrd_daemon . $arg;
}
