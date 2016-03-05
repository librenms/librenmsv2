<?php

use Illuminate\Database\Seeder;
use App\Device;
use App\Port;

class InsertPortsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devices = Device::all();
        foreach ($devices as $device) {
            $device_id = $device->device_id;
            $data  = ['device_id' => $device_id, 'ifIndex' => 1, 'ifDescr' => 'eth0', 'ifName' => 'eth0', 'ifSpeed' => 1000000, 'ifOperStatus' => 'up', 'ifAdminStatus' => 'up', 'ifType' => 'ethernetCsmacd', 'ifAlias' => 'eth0'];
            $device->ports()->create($data);
        }
    }
}
