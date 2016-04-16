<?php

use App\Models\User;
use App\Models\Widgets;
use App\Models\UsersWidgets;
use Illuminate\Http\Response;
use JWTAuth;

class OverviewApiTest extends TestCase
{

    /**
     * Test overview api
    **/

    public function testDashboardsApi()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $jwt = JWTAuth::fromUser($user);
        $data = ['user_id' => $user->user_id, 'name' => 'Test Dashboard', 'access' => '0',];
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('POST','/api/dashboard?token='.$jwt, array_merge($data,$this->headers))->seeStatusCode(Response::HTTP_OK)->seeJson([
            'statusText' => 'OK'
        ]);
        $dashboards = $this->get('/api/dashboard?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'dashboard_name' => 'Test Dashboard'
        ]);
    }

    public function testWidgetsApi()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $jwt = JWTAuth::fromUser($user);
        $data = ['widget_title' => 'Test Widget', 'widget' => 'test-widget', 'base_dimensions' => '4,3'];
        $widgets = Widgets::create($data);

        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->get('/api/widget?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'widget_title' => 'Test Widget'
        ]);
    }

    public function testUserWidgetsApi()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $jwt = JWTAuth::fromUser($user);
        $data = ['user_id' => $user->user_id, 'widget_id' => 1, 'col' => 1, 'row' => 2, 'size_x' => 1, 'size_y' => 2, 'title' => 'Test Widget', 'settings' => '', 'dashboard_id' => 1];
        $users_widgets = UsersWidgets::create($data);

        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->get('/api/dashboard-widget/1?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'statusText' => 'OK'
        ]);
    }
}
