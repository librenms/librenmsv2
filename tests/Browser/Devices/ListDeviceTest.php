<?php
namespace Tests\Browser\Devices;

use App\Models\Device;
use App\Models\User;
use Tests\BrowserKitTestCase;

class ListDeviceTest extends BrowserKitTestCase
{

    /**
     * Make sure we see a list of devices
     *
     **/

    public function testListingDevices()
    {
        $device = factory(Device::class)->create();
        $restricted_device = factory(Device::class)->create();

        $admin_user = factory(User::class)->states(['admin'])->create();
        $this->actingAs($admin_user)
            ->visit('/devices');
        //FIXME

        $normal_user = factory(User::class)->create();
        $normal_user->devices()->save($restricted_device);

        $this->actingAs($normal_user)
            ->visit('/devices');
        //FIXME
    }
}
