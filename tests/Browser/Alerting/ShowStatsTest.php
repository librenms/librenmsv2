<?php
/**
 * tests/webui/alerting/ShowStatsTest.php
 *
 * Test unit for Webui alerts stats page.
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

namespace Tests\Browser\Alerting;

use App\Models\Alerting\Log;
use App\Models\User;
use Tests\BrowserKitTestCase;

class ShowStatsTest extends BrowserKitTestCase
{

    /**
     * Make sure we see the stats page header
     *
    **/

    public function testShowStats()
    {
        $user = factory(User::class)->create([
            'level' => 10,
        ]);
        factory(Log::class, 5)->create();

        $this->actingAs($user)
             ->visit('/alerting/stats')
             ->see('Alerting statistics');
    }
}
