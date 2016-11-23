<?php
namespace Tests\Webui\Devices;

use App\Models\Device;
use App\Models\User;
use Tests\TestCase;

class ListDeviceTest extends TestCase
{

    /**
     * Make sure we see a list of devices
     *
    **/

    public function testListingDevices()
    {
        $this->seed();
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        $this->actingAs($user)
             ->visit('/devices');

        $user = factory(User::class)->create([
            'level' => 1,
        ]);

        $device = Device::where('hostname', 'restrictedhost')->first();
        $user->devices()->attach($device);

        $this->actingAs($user)
             ->visit('/devices');
    }
}
