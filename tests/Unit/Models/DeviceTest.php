<?php
/*
 * Copyright (C) 2016 Tony Murray <murraytony@gmail.com>
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
 */
/**
 * DeviceTest.php
 *
 * @package    LibreNMS
 * @author     Tony Murray <murraytony@gmail.com>
 * @copyright  2016 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */
namespace Tests\Webui\Models;

use App\Models\Device;
use App\Models\Port;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use DatabaseTransactions;

    public function testCascadingDelete()
    {
        $device = factory(Device::class)->create();
        $device_id = $device->device_id;
        for ($i = 0; $i < random_int(1, 24); $i++) {
            $device->ports()->save(factory(Port::class)->make());
        }
        $this->assertNotEmpty($device->ports()->get());

        $device->delete();
        $result = DB::table('ports')->where('device_id', $device_id)->get();
        $this->assertEmpty($result);
    }
}
