<?php
use App\Models\Device;

/**
 * @param $name
 * @return mixed
 */
function safename($name)
{
    return preg_replace('/[^\w\d,._\-]/', '_', $name);
}

/**
 * @param $string
 * @return mixed
 */
function shorten_interface_type($string)
{
    return str_ireplace(
        array(
            'FastEthernet',
            'TenGigabitEthernet',
            'GigabitEthernet',
            'Port-Channel',
            'Ethernet',
        ),
        array(
            'Fa',
            'Te',
            'Gi',
            'Po',
            'Eth',
        ),
        $string
    );
}//end shorten_interface_type()

/**
 * @param $port_id
 * @param string $suffix
 * @return string
 */
function getPortRrdName($port_id, $suffix = '')
{
    if (!empty($suffix)) {
        $suffix = '-' . $suffix;
    }

    return "port-id$port_id$suffix";
}

/**
 * @param Device $device
 * @param $port_id
 * @param string $suffix
 * @return string
 */
function get_port_rrdfile_path($device, $port_id, $suffix = '')
{
    return rrd_name($device, getPortRrdName($port_id, $suffix));
}
