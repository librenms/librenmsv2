<?php
/**
 * SettingsTest.php
 *
 * -Description-
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace Api;

use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Response;
use Settings;
use Tests\ApiTestCase;

class SettingsTest extends ApiTestCase
{
    private $endpoint = '/api/settings';

    public function test_401_when_unauthorized()
    {
        $this->json('GET', $this->endpoint)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_can_set_settings()
    {
        $admin_user = factory(User::class)->states(['admin'])->create();

        $this->post($this->endpoint, ['setting' => 'api_test', 'value' => 'set'], $this->headers($admin_user))
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertEquals('set', Settings::get('api_test'));
    }

    public function test_can_get_settings()
    {
        $admin_user = factory(User::class)->states(['admin'])->create();
        $user = factory(User::class)->create();

        Auth::login($admin_user);
        Settings::set('api_test', 'get');

        $this->get($this->endpoint, $this->headers($user))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['api_test' => 'get']);
    }


    public function test_can_get_multiple_settings()
    {
        $admin_user = factory(User::class)->states(['admin'])->create();
        $user = factory(User::class)->create();
        $data = ['one' => 'Tony', 'two' => 'Neil'];

        Config::set('config.names', $data);
//        Settings::set('names', $data);

        $this->get('api/settings/names.one', $this->headers($user))
            ->assertSeeText('Tony');
        $this->get('api/settings/names')
            ->assertJson($data);

    }
}
