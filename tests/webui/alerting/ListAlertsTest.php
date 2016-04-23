<?php

use App\Models\Alerting\Alerts;
use App\Models\User;

class ListAlertsTest extends TestCase
{

    /**
     * Make sure we see a list of alerts
     *
    **/

    public function testListingAlerts()
    {
        $this->seed();
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        for ($x=0;$x<5;$x++) {
            $alert = factory(Alerts::class)->create();
        }
        $this->actingAs($user)
             ->visit('/alerting/alerts')
             ->see('Timestamp');

    }

}
