<?php
namespace Tests\Browser\Users;

use App\Models\Dashboard;
use Tests\BrowserKitTestCase;

class UserCanLoginTest extends BrowserKitTestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */

    public function testLoggingInAsUser()
    {
        $user = factory(\App\Models\User::class)->create();

        $data = ['user_id' => $user['user_id'], 'dashboard_name' => 'Test Dashboard', 'access' => '0'];
        $dashboard = Dashboard::create($data);

        $this->actingAs($user)
             ->visit('/dashboard/'.$dashboard['dashboard_id'])
             ->see('Dashboard');
    }

    public function testLoggingOut()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->actingAs($user)
             ->visit('/devices')
            ->press('Logout')
             ->seePageIs('/login');
    }

    public function testLoginFormFail()
    {
        // Try logging in with no credentials
        $this->visit('/login')
             ->press('submit')
             ->see('has-error');
    }

    public function testManualLogin()
    {
        // Disabled for now until we get login redirects working

        /**
        $password = str_random(10);
        $user = factory(User::class)->create([
            'password' => bcrypt($password),
        ]);

        $data = ['user_id' => $user->user_id, 'dashboard_name' => 'Test Dashboard', 'access' => '0'];
        $dashboard = Dashboard::create($data);

        $this->visit('/login')
             ->type($user->username,'username')
             ->type($password,'password')
             ->check('remember')
             ->press('submit')
             ->seePageIs('/dashboard/'.$dashboard->dashboard_id);
        **/
    }
}
