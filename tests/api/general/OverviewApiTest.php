<?php
/**
 * tests/api/general/OverviewApiTest.php
 *
 * Test unit for overview/dashboard api
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */
namespace Tests\Api\General;

use App\Models\User;
use App\Models\UsersWidgets;
use App\Models\Widgets;
use Illuminate\Http\Response;
use JWTAuth;
use Tests\TestCase;

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
        $headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('POST', '/api/dashboard?token='.$jwt, array_merge($data, $headers))->seeStatusCode(Response::HTTP_OK)->seeJson([
            'statusText' => 'OK'
        ]);
        $this->json('GET', '/api/dashboard?token='.$jwt, $headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
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

        $headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->get('/api/widget?token='.$jwt, $headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'widget_title' => 'Test Widget'
        ]);
    }

    public function testUserWidgetsApi()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $jwt = JWTAuth::fromUser($user);
        $widget_id = Widgets::first()->widget_id;
        $data = ['user_id'      => $user->user_id,
                 'widget_id'    => $widget_id,
                 'col'          => 1,
                 'row'          => 2,
                 'size_x'       => 1,
                 'size_y'       => 2,
                 'title'        => 'Test Widget',
                 'settings'     => '',
                 'dashboard_id' => 1,
        ];
        $users_widgets = UsersWidgets::create($data);

        $headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->delete('/api/widget/'.$users_widgets->user_widget_id.'?token='.$jwt, $headers)
            ->seeStatusCode(Response::HTTP_OK);
    }
}
