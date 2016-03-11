<?php

use App\Models\User;

class UserCanLoginTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */


    public function testLoggingInAsUser()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/')
             ->see('Dashboard');
    }

    public function testLoggingOut()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/')
             ->click('Logout')
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
        $password = str_random(10);
        $user = factory(User::class)->create([
            'password' => bcrypt($password),
        ]);
        $this->visit('/login')
             ->type($user->username,'username')
             ->type($password,'password')
             ->check('remember')
             ->press('submit')
             ->seePageIs('/');
    }

}
