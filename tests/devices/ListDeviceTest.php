<?php

use App\User;

class ListDeviceTest extends TestCase
{

    /**
     * Make sure we see a list of devices
     *
    **/

    public function testListingDevices()
    {
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        $this->actingAs($user)
             ->visit('/devices')
             ->see('localhost')
             ->see('remotehost');

        $user = factory(User::class)->create([
            'level' => 1,
        ]);

        $data = ['hostname' => 'restrictedhost', 'sysName' => 'mysystem', 'version' => '1.1', 'hardware' => 'Intel x64', 'location' => 'Some place in the world', 'status' => 1, 'status_reason' => ''];
        $device_id = DB::table('devices')->insertGetId($data);

        $data = ['user_id' => $user->user_id, 'device_id' => $device_id, 'access_level' => 0];
        DB::table('devices_perms')->insert($data);

        $this->actingAs($user)
             ->visit('/devices')
             ->see('restrictedhost');
    }

}
