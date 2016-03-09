<?php

use App\User;
use App\Device;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPreferencesPageTest extends TestCase
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
             ->see('Current password')
             ->see('New password')
             ->see('Repeat password');
    }

    /**
     * Test if we can see the device permissions section.
     *
     * @return void
     */
    public function testCanSeeDevicePermissionsAdmin()
    {
        $this->seed();
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
        $this->seed();
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
             ->see('Device / Port permissions');

    }

}
