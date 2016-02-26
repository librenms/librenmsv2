<?php

namespace App\Api\Controllers;

use DB;
use App\User;
use App\Device;
use App\Port;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
    * Get info about the install
    */
    public function get_info()
    {
        $versions['git'] = `git rev-parse --short HEAD`;
        $versions['db_schema'] = DB::select('SELECT `version` FROM `dbSchema` LIMIT 1')[0]->version;
        $versions['php'] = phpversion();
        $versions['mysql'] = DB::select('SELECT version() AS version')[0]->version;
        if (empty($_SERVER['SERVER_SOFTWARE'])) {
            $_SERVER['SERVER_SOFTWARE'] = "";
        }
        $versions['apache'] = str_replace('Apache/', '', $_SERVER['SERVER_SOFTWARE']);
        return $versions;
    }

    /**
     * Get statistics about the install
    **/
    public function get_stats()
    {
        $stats['devices']    = DB::select('SELECT COUNT(device_id) AS `total` FROM `devices`')[0]->total;
        $stats['ports']      = DB::select('SELECT COUNT(port_id) AS `total` FROM `ports`')[0]->total;
        $stats['syslog']     = DB::select('SELECT COUNT(seq) AS `total` FROM `syslog`')[0]->total;
        $stats['eventlog']     = DB::select('SELECT COUNT(event_id) AS `total` FROM `eventlog`')[0]->total;
        $stats['apps']       = DB::select('SELECT COUNT(app_id) AS `total` FROM `applications`')[0]->total;
        $stats['services']   = DB::select('SELECT COUNT(service_id) AS `total` FROM `services`')[0]->total;
        $stats['storage']    = DB::select('SELECT COUNT(storage_id) AS `total` FROM `storage`')[0]->total;
        $stats['diskio']     = DB::select('SELECT COUNT(diskio_id) AS `total` FROM `ucd_diskio`')[0]->total;
        $stats['processors'] = DB::select('SELECT COUNT(processor_id) AS `total` FROM `processors`')[0]->total;
        $stats['memory']     = DB::select('SELECT COUNT(mempool_id) AS `total` FROM `mempools`')[0]->total;
        $stats['sensors']    = DB::select('SELECT COUNT(sensor_id) AS `total` FROM `sensors`')[0]->total;
        $stats['toner']      = DB::select('SELECT COUNT(toner_id) AS `total` FROM `toner`')[0]->total;
        $stats['hrmib']      = DB::select('SELECT COUNT(hrDevice_id) AS `total` FROM `hrDevice`')[0]->total;
        $stats['entmib']    = DB::select('SELECT COUNT(entPhysical_id) AS `total` FROM `entPhysical`')[0]->total;
        $stats['ipv4_addr']  = DB::select('SELECT COUNT(ipv4_address_id) AS `total` FROM `ipv4_addresses`')[0]->total;
        $stats['ipv4_net']  = DB::select('SELECT COUNT(ipv4_network_id) AS `total` FROM `ipv4_networks`')[0]->total;
        $stats['ipv6_addr']  = DB::select('SELECT COUNT(ipv6_address_id) AS `total` FROM `ipv6_addresses`')[0]->total;
        $stats['ipv6_net']  = DB::select('SELECT COUNT(ipv6_network_id) AS `total` FROM `ipv6_networks`')[0]->total;
        $stats['pw']         = DB::select('SELECT COUNT(pseudowire_id) AS `total` FROM `pseudowires`')[0]->total;
        $stats['vrf']        = DB::select('SELECT COUNT(vrf_id) AS `total` FROM `vrfs`')[0]->total;
        $stats['vlans']      = DB::select('SELECT COUNT(vlan_id) AS `total` FROM `vlans`')[0]->total;
        return $stats;
    }

}
