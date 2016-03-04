<?php

class AddDefaultDataTest extends TestCase
{

    /**
     * Add a dbSchema version
     */
    public function testAdddbSchemaVersion()
    {
        $data = ['version' => 100];
        DB::table('dbSchema')->insert($data);
    }

    /**
     * Add a device entry to the DB
     */
    public function testaddDeviceData()
    {
        $data_array = [
                ['hostname' => 'localhost', 'sysName' => 'mysystem', 'version' => '1.1', 'hardware' => 'Intel x64', 'location' => 'Some place in the world', 'status' => 1, 'status_reason' => ''],
                ['hostname' => 'remotehost', 'sysName' => 'someonessystem', 'version' => '2.2', 'hardware' => 'AMD x64', 'location' => 'Some other place in the world', 'status' => 0, 'status_reason' => 'icmp'],
        ];
        foreach ($data_array as $data) {
            DB::table('devices')->insert($data);
        }
    }

    /**
     * Add port entries for devices
     */
    public function testaddPortData()
    {
        $devices = DB::select('SELECT `device_id` FROM `devices`');
        foreach ($devices as $device) {
            $device_id = $device->device_id;
            $data = ['device_id' => $device_id, 'ifIndex' => $device_id, 'ifDescr' => 'eth0', 'ifName' => 'eth0', 'ifSpeed' => 1000000, 'ifOperStatus' => 'up', 'ifAdminStatus' => 'up', 'ifType' => 'ethernetCsmacd', 'ifAlias' => 'eth0'];
            DB::table('ports')->insert($data);
        }
    }

}
