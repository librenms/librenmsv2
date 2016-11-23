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
namespace Tests\Api\General;

use App\Models\General\IPv4;
use App\Models\General\IPv4Mac;
use App\Models\General\IPv6;
use App\Models\Port;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SearchApiTest extends TestCase
{

    /**
     * Test search ipv4 api
    **/
    public function testSearchIPv4Api()
    {
        $this->seed();
        $user = factory(User::class)->create();
        for ($x = 0; $x < 5; $x++) {
            factory(IPv4::class)->create();
        }
        $total = IPv4::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/ipv4?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'total' => $total,
        ]);
    }

    /**
     * Test search ipv6 api
    **/
    public function testSearchIPv6Api()
    {
        $this->seed();
        $user = factory(User::class)->create();
        for ($x = 0; $x < 5; $x++) {
            factory(IPv6::class)->create();
        }
        $total = IPv6::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/ipv6?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'total' => $total,
        ]);
    }

    /**
     * Test search mac api
    **/
    public function testSearchMacApi()
    {
        $this->seed();
        $user = factory(User::class)->create();
        for ($x = 0; $x < 5; $x++) {
            factory(Port::class)->create();
        }
        $total = Port::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/mac?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'total' => $total,
        ]);
    }

    /**
     * Test search arp api
    **/
    public function testSearchArpApi()
    {
        $this->seed();
        $user = factory(User::class)->create();
        for ($x = 0; $x < 5; $x++) {
            factory(IPv4Mac::class)->create();
        }
        $total = IPv4Mac::all()->count();
        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.' . env('API_VENDOR', '') . '.v1+json'
        ];
        $this->json('GET', '/api/search/arp?token='.$jwt, $this->headers)->seeStatusCode(Response::HTTP_OK)->seeJson([
            'total' => $total,
        ]);
    }
}
