<?php

use App\User;

class AboutPageTest extends TestCase
{

    /**
     * Test about page
    **/

    public function testAboutPage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/about')
             ->see('This program is free software:')
             ->see('Contributors')
             ->see('Statistics');
    }
}
