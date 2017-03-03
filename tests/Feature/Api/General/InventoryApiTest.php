<?php
/**
 * tests/api/general/InventoryApiTest.php
 *
 * Test unit for inventory api
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

use App\Models\General\Inventory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use JWTAuth;
use Tests\TestCase;

class InventoryApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test inventory api
     **/

    public function testInventoryApi()
    {
        $user = factory(User::class)->create();
        factory(Inventory::class, 5)->create();

        $jwt = JWTAuth::fromUser($user);
        $this->headers = [
            'HTTP_ACCEPT' => 'application/vnd.'.env('API_VENDOR', '').'.v1+json',
        ];
        $this->json('GET', '/api/inventory?token='.$jwt, $this->headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['total' => 5]);
    }
}
