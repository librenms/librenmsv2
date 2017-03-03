<?php
/**
 * ManageUsersPageTest.php
 *
 * Tests access to the User Management Page
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */
namespace Tests\Browser\Users;

use App\Models\Device;
use App\Models\Port;
use App\Models\User;
use Auth;
use Tests\BrowserKitTestCase;

class ManageUsersPageTest extends BrowserKitTestCase
{

    /**
     * Test that the users page is redirected to
     * preferences for non-admin users
     *
     * @return void
     */
    public function testPreferenceRedirect()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit('/users')
            ->dontSee('Manage Users');
    }

    /**
     * Test the datatable page.
     *
     * @return void
     */
    public function testAdminPage()
    {
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        $this->actingAs($user)
            ->visit('/users')
            ->see('Manage Users')
            ->see('Create New User')
            ->see('Edit')
            ->see('Delete')
            ->see($user->username);
    }

    /**
     * Test the edit page
     *
     * @return void
     */
    public function testEditPage()
    {
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        Auth::login($user);

        $normalUser = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $normalUser->devices()->attach($device);

        $port = factory(Port::class)->create();
        $device->ports()->save($port);
        $normalUser->ports()->attach($port);

        $this->actingAs($user)
            ->visit('/users/'.$normalUser->user_id.'/edit')
            ->see($normalUser->username)
            ->see('User Info')
            ->see('Password')
            ->see('Device permissions')
            ->see('Port permissions')
            ->see($device->hostname)
            ->see($port->ifName);
    }
}
