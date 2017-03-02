<?php
/**
 * tests/api/general/DeviceApiTest.php
 *
 * Test unit for device api
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

namespace Tests\Api;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use JWTAuth;
use Tests\TestCase;

class DeviceApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test overview api
    **/

    public function testDeviceApi()
    {
        $user = factory(User::class)->create(['level'=>10]);
        factory(Device::class, 5)->create();

        $jwt = JWTAuth::fromUser($user);
        $count = Device::all()->count();
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/devices?token='.$jwt, $this->headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['total' => $count]);
    }
}
