<?php

function format_proc_descr($descr)
{
    $bad_descr = array(
        '/GenuineIntel:/' => '',
        '/AuthenticAMD:/' => '',
        '/Intel(R)/' => '',
        '/CPU/' => '',
        '/(R)/' => '',
        '/  /' => ' ',
    );

    foreach ($bad_descr as $find => $replace) {
        $descr = preg_replace($find, $replace, $descr);
    }

    return $descr;
}

