<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ListDeviceTest extends TestCase
{

    /**
     * Make sure we see a list of devices
     *
    **/

    public function testListingDevices()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/devices')
             ->see('localhost')
             ->see('remotehost');
    }

}
