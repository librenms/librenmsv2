<?php
namespace Tests\Webui\General;

use App\Models\User;
use Tests\TestCase;

class AboutPageTest extends TestCase
{

    /**
     * Test about page
    **/

    public function testAboutPage()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/about')
             ->see('This program is free software:')
             ->see('Contributors')
             ->see('Statistics');
    }
}
