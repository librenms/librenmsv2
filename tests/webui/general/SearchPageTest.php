<?php
/**
 * tests/webui/general/SearchPageTest.php
 *
 * Test unit for webui search page
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

use App\Models\User;

class SearchPageTest extends TestCase
{

    /**
     * Test Search IPv4 page
    **/
    public function testSearchIPv4Page()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('search/ipv4');
    }

    /**
     * Test Search IPv6 page
    **/
    public function testSearchIPv6Page()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('search/ipv6');
    }

    /**
     * Test Search Mac page
    **/
    public function testSearchMacPage()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('search/mac');
    }

    /**
     * Test Search Arp page
    **/
    public function testSearchArpPage()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('search/arp');
    }


}
