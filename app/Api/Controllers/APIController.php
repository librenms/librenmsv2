<?php

namespace App\Api\Controllers;

use DB;

class ApiController extends Controller
{
    /**
     * Get info about the install
     */
    public function get_info()
    {
        $versions              = array();
        $versions['git']       = `git rev-parse --short HEAD`;
        $versions['db_schema'] = DB::select('SELECT `version` FROM `dbSchema` LIMIT 1')[0]->version;
        $versions['php']       = phpversion();
        if (!DB::connection()->getDatabaseName() === ':memory:')
        {
            $versions['mysql'] = DB::select('SELECT version() AS version')[0]->version;
        }
        else {
            $versions['mysql'] = 'SQLite3';
        }
        return $versions;
    }

    /**
     * Get statistics about the install
     */
    public function get_stats()
    {
        $stats               = array();
        $stats['devices']    = \App\Device::all()->count();
        $stats['ports']      = \App\Port::all()->count();
        $stats['syslog']     = \App\Syslog::all()->count();
        $stats['eventlog']   = \App\Eventlog::all()->count();
        $stats['apps']       = DB::table('applications')->count();;
        $stats['services']   = DB::table('services')->count();
        $stats['storage']    = DB::table('storage')->count();
        $stats['diskio']     = DB::table('ucd_diskio')->count();
        $stats['processors'] = DB::table('processors')->count();
        $stats['memory']     = DB::table('mempools')->count();
        $stats['sensors']    = DB::table('sensors')->count();
        $stats['toner']      = DB::table('toner')->count();
        $stats['hrmib']      = DB::table('hrDevice')->count();
        $stats['entmib']     = DB::table('entPhysical')->count();
        $stats['ipv4_addr']  = DB::table('ipv4_addresses')->count();
        $stats['ipv4_net']   = DB::table('ipv4_networks')->count();
        $stats['ipv6_addr']  = DB::table('ipv6_addresses')->count();
        $stats['ipv6_net']   = DB::table('ipv6_networks')->count();
        $stats['pw']         = DB::table('pseudowires')->count();
        $stats['vrf']        = DB::table('vrfs')->count();
        $stats['vlans']      = DB::table('vlans')->count();
        return $stats;
    }

}
