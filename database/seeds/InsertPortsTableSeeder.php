<?php

use Illuminate\Database\Seeder;

class InsertPortsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devices = DB::select('SELECT `device_id` FROM `devices`');
        foreach ($devices as $device) {
            $device_id = $device->device_id;
            $data = ['device_id' => $device_id, 'ifIndex' => $device_id, 'ifDescr' => 'eth0', 'ifName' => 'eth0', 'ifSpeed' => 1000000, 'ifOperStatus' => 'up', 'ifAdminStatus' => 'up', 'ifType' => 'ethernetCsmacd', 'ifAlias' => 'eth0'];
            DB::table('ports')->insert($data);
        }
    }
}
