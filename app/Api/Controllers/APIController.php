<?php

namespace App\Api\Controllers;

use App\Models\Device;
use App\Models\General\Eventlog;
use App\Models\General\IPv4;
use App\Models\General\Syslog;
use App\Models\Port;
use DB;

class ApiController extends Controller
{
    /**
     * Get info about the install
     */
    public function getInfo()
    {
        $git = `git rev-parse --short HEAD`;

        $schema = DB::table('dbSchema')->select('version')->pluck('version')->last();
        $migration = DB::table('migrations')->select('migration')->pluck('migration')->last();
        $db_schema = $schema ?: $migration;

        $php = phpversion();

        $db_driver = strtoupper(DB::connection()->getDriverName());

        if ($db_driver == 'SQLITE') {
            $db_version = collect(DB::select('SELECT sqlite_version() AS version'))->pluck('version')->first();
        } else {
            $db_version = collect(DB::select('SELECT version() AS version'))->pluck('version')->first();
        }

        return compact('git', 'db_schema', 'php', 'db_driver', 'db_version');
    }

    /**
     * Get statistics about the install
     */
    public function getStats()
    {
        $stats = [
            'devices'    => Device::count(),
            'ports'      => Port::count(),
            'syslog'     => Syslog::count(),
            'eventlog'   => Eventlog::count(),
            'apps'       => DB::table('applications')->count(),
            'services'   => DB::table('services')->count(),
            'storage'    => DB::table('storage')->count(),
            'diskio'     => DB::table('ucd_diskio')->count(),
            'processors' => DB::table('processors')->count(),
            'memory'     => DB::table('mempools')->count(),
            'sensors'    => DB::table('sensors')->count(),
            'toner'      => DB::table('toner')->count(),
            'hrmib'      => DB::table('hrDevice')->count(),
            'entmib'     => DB::table('entPhysical')->count(),
            'ipv4_addr'  => IPv4::count(),
            'ipv4_net'   => DB::table('ipv4_networks')->count(),
            'ipv6_addr'  => DB::table('ipv6_addresses')->count(),
            'ipv6_net'   => DB::table('ipv6_networks')->count(),
            'pw'         => DB::table('pseudowires')->count(),
            'vrf'        => DB::table('vrfs')->count(),
            'vlans'      => DB::table('vlans')->count(),
        ];

        return $stats;
    }
}
