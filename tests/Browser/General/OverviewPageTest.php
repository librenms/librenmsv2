<?php
namespace Tests\Browser\General;

use App\Models\Dashboard;
use App\Models\User;
use Tests\BrowserKitTestCase;

class OverviewPageTest extends BrowserKitTestCase
{

    /**
     * Test overview page
    **/

    public function testOverviewPage()
    {
        $user = factory(User::class)->create();

        $data = ['user_id' => $user['user_id'], 'dashboard_name' => 'Test Dashboard', 'access' => '0'];
        $dashboard = Dashboard::create($data);

        $this->actingAs($user)
             ->visit('/dashboard/'.$dashboard['dashboard_id'])
             ->see('Test Dashboard');
    }
}
