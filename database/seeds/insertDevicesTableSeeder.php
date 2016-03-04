<?php

use Illuminate\Database\Seeder;

class insertDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_array = [
            ['hostname' => 'myhost', 'ip' => inet_pton('127.0.0.1'), 'sysName' => 'mysystem', 'version' => '1.1', 'hardware' => 'Intel x64', 'location' => 'Some place in the world', 'status' => 1, 'status_reason' => ''],
            ['hostname' => 'remotehost', 'ip' => inet_pton('::1'), 'sysName' => 'someonessystem', 'version' => '2.2', 'hardware' => 'AMD x64', 'location' => 'Some other place in the world', 'status' => 0, 'status_reason' => 'icmp'],
        ];
        foreach ($data_array as $data) {
            DB::table('devices')->insert($data);
        }
    }
}
