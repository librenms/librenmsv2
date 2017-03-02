<?php
/**
 * tests/api/general/SearchApiTest.php
 *
 * Test unit for search api
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
namespace Tests\Feature\Api\General;

use App\Models\General\IPv4;
use App\Models\General\IPv4Mac;
use App\Models\General\IPv6;
use App\Models\Port;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use JWTAuth;
use Tests\TestCase;

class SearchApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test search ipv4 api
    **/
    public function testSearchIPv4Api()
    {
        $user = factory(User::class)->create();
        for ($x = 0; $x < 5; $x++) {
            factory(IPv4::class)->create();
        }
        $total = IPv4::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/ipv4?token='.$jwt, $this->headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['total' => $total]);
    }

    /**
     * Test search ipv6 api
    **/
    public function testSearchIPv6Api()
    {
        $user = factory(User::class)->create();
        for ($x = 0; $x < 5; $x++) {
            factory(IPv6::class)->create();
        }
        $total = IPv6::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/ipv6?token='.$jwt, $this->headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['total' => $total]);
    }

    /**
     * Test search mac api
    **/
    public function testSearchMacApi()
    {
        $user = factory(User::class)->create();
        factory(Port::class, 5)->create();

        $total = Port::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/mac?token='.$jwt, $this->headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['total' => $total]);
    }

    /**
     * Test search arp api
    **/
    public function testSearchArpApi()
    {
        $user = factory(User::class)->create();
        factory(IPv4Mac::class, 5)->create();

        $total = IPv4Mac::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/arp?token='.$jwt, $this->headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['total' => $total]);
    }
}
