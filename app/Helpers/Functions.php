<?php

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
