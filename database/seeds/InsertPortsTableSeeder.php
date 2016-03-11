<?php

use App\Models\Device;
use App\Models\Port;
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
        $devices = Device::all();
        foreach ($devices as $device) {
            $data  = ['ifIndex' => 1, 'ifDescr' => 'eth0', 'ifName' => 'eth0', 'ifSpeed' => 1000000, 'ifOperStatus' => 'up', 'ifAdminStatus' => 'up', 'ifType' => 'ethernetCsmacd', 'ifAlias' => 'eth0'];
            $device->ports()->create($data);
        }
    }
}
