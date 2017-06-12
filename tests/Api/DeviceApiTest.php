<?php
/**
 * DeviceApiTest.php
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

namespace Tests\Api;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\ApiTestCase;

class DeviceApiTest extends ApiTestCase
{
    private $endpoint = '/api/devices';

    public function test_401_when_unauthorized()
    {
        $this->json('GET', $this->endpoint)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_list_all_devices()
    {
        $user = factory(User::class)->states(['globalread'])->create();

        factory(Device::class, 5)->create();
        $all = ['devices' => Device::all()->toArray()];

        $this->get($this->endpoint, $this->headers($user))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($all);
    }

    public function test_results_are_restricted()
    {
        $user = factory(User::class)->create();

        factory(Device::class, 5)->create();
        $devices = Device::orderBy('device_id', 'desc')->limit(2)->get();
        $user->devices()->saveMany($devices);

        $this->get($this->endpoint, $this->headers($user))
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['devices' => $devices->toArray()])
            ->assertJsonMissing(['device_id' => Device::first()->device_id]);
    }

    public function test_can_fetch_device_by_id()
    {
        $user = factory(User::class)->create();
        factory(Device::class)->create();
        $device = Device::first();
        $user->devices()->save($device);

        $this->get($this->endpoint.'/'.$device->device_id, $this->headers($user))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['device' => $device->toArray()]);

    }

    public function test_can_select_fields()
    {
        $user = factory(User::class)->states(['globalread'])->create();
        factory(Device::class)->create();

        $this->get($this->endpoint.'?fields=device_id,hostname,os', $this->headers($user))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['devices' => Device::select(['device_id', 'hostname', 'os'])->first()->toArray()]);
    }
}
