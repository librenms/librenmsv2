<?php
namespace App\OS;

class Linux extends AbstractOS {
    protected $type      = 'server';
    protected $group     = 'unix';
    protected $text      = 'Linux';
    protected $icon      = 'linux';
    protected $attrib    = array(
                               'ifXmcbc' => true,
                               'ifname'  => true,
                           );
    protected $overlib   = array(
                               array(
                                   'graph' => 'device_processor',
                                   'text'  => 'Processor Usage'
                               ),
                               array(
                                   'graph' => 'device_ucd_memory',
                                   'text'  => 'Memory Usage'
                               ),
                               array(
                                   'graph' => 'device_storage',
                                   'text'  => 'Storage Usage'
                               ),
                           );
    protected $derivates = array(
                               'Debian' => array(
                                              'icon' => 'debian',
                                           ),
                               'CentOS' => array(
                                              'icon' => 'centos',
                                           ),
                               'Ubuntu' => array(
                                              'icon' => 'ubuntu',
                                           ),
                           );
}
