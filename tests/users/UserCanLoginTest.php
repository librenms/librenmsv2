<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCanLoginTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLoggingInAsUser()
    {

        $user = factory(User::class)->create(['username' => 'johndoe']);

        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('/')
             ->see('Dashboard');
    }

    public function testLoggingOut()
    {
        $this->click('Logout')
             ->seePageIs('/logout');
    }
}
