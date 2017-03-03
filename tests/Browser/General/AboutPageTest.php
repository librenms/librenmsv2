<?php
namespace Tests\Browser\General;

use App\Models\User;
use Tests\BrowserKitTestCase;

class AboutPageTest extends BrowserKitTestCase
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
