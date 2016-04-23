<?php

use Illuminate\Http\Response;
use JWTAuth;
use App\Models\Alerting\Alerts;
use App\Models\User;

class AlertsApiTest extends TestCase
{

    /**
     * Test alerts api
    **/

    public function testAlertsApi()
    {
        $alerts = factory(Alerts::class)->create();
        $user = factory(User::class)->create();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/alerting/alerts?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'total' => 1
        ]);
    }
}
