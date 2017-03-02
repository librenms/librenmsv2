<?php
namespace Tests\Browser\Users;

use App\Models\Device;
use App\Models\User;
use Tests\BrowserKitTestCase;

class UserPreferencesPageTest extends BrowserKitTestCase
{

    /**
     * Test if we can see the password reset form.
     *
     * @return void
     */
    public function testCanSeePasswordForm()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/preferences')
             ->see('Current Password')
             ->see('Password')
             ->see('Password Confirmation');
    }

    /**
     * Test if we can see the device permissions section.
     *
     * @return void
     */
    public function testCanSeeDevicePermissionsAdmin()
    {
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        $this->actingAs($user)
             ->visit('/preferences')
             ->see('Device / Port permissions')
             ->see('Global Administrative Access');
    }

    /**
     * Test if we can see the device permissions section.
     *
     * @return void
     */
    public function testCanSeeDevicePermissionsRead()
    {
        $user = factory(User::class)->create([
            'level' => 5,
        ]);
        $this->actingAs($user)
             ->visit('/preferences')
             ->see('Device / Port permissions')
             ->see('Global Viewing Access');
    }

    /**
     * Test if we can see the device permissions section.
     *
     * @return void
     */
    public function testCanSeeDevicePermissionsNormal()
    {
        $this->seed();
        $user = factory(User::class)->create([
            'level' => 1,
        ]);

        $device = Device::where('hostname', 'restrictedhost')->first();
        $user->devices()->attach($device);

        $this->actingAs($user)
             ->visit('/preferences')
             ->see('Device / Port permissions')
             ->see('Show devices');
    }
}
