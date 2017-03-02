<?php
/*
 * Copyright (C) 2017 Tony Murray <murraytony@gmail.com>
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
 * @copyright  2017 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */
namespace Tests\Unit\Models;

use App\Models\DeviceGroup;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Settings;
use Tests\TestCase;

class DeviceGroupTest extends TestCase
{
    use DatabaseTransactions;

    public function testV1Parser()
    {
        $user = factory(User::class)->create(['level' => 10]);
        Auth::login($user);
        Settings::set('alert.macros.group.deviceid', '%devices.disabled = "0" && %devices.ignore = "0"');

        $data = [
            ['input'  => '%devices.hostname ~ "Test input" &&',
                'result' => "devices.hostname LIKE('%Test input%')"],

            ['input'  => '%devices.hostname !~ "more.@-@" &&',
                'result' => "devices.hostname NOT LIKE('more.%-%')"],

            ['input'  => '%devices.device_id < "50" && %sensors.sensor_id != "179" &&',
                'result' => "devices.device_id < '50' AND sensors.sensor_id != '179'"],

            ['input'  => '%devices.device_id = "42" || %devices_attribs.attrib_value ~ "@end" || %devices.hostname = "fun time" &&',
                'result' => "devices.device_id = '42' OR devices_attribs.attrib_value LIKE('%end') OR devices.hostname = 'fun time'"],

            ['input'  => '%macros.deviceid = 1 && %ports.ifType = "ethernetCsmacd"',
                'result' => "macros.deviceid = '1' AND ports.ifType = 'ethernetCsmacd'"],

// Bad input
//            ['input'  => '%devices.hostname = ""fun"" && %devices.hostname = "\'fun\'" &&',
//             'result' => 'devices.hostname = ""fun"" && devices.hostname = "\'fun\'" &&'],
        ];

        $group = DeviceGroup::create(['name' => 'test', 'pattern' => '1']);
        $group_id = $group->id;
        foreach ($data as $item) {
            DB::table('device_groups')->where('id', $group_id)->update(['pattern' => $item['input']]);
            $this->assertEquals($item['result'], DeviceGroup::find($group_id)->pattern);
        }
    }

    public function testMacros()
    {
        $macro = '%devices.disabled = "0" && %devices.ignore = "0"';
        $expected = '(devices.disabled = "0" AND devices.ignore = "0") = 1';

        $user = factory(User::class)->create(['level' => 10]);
        Auth::login($user);
        Settings::set('alert.macros.group.device', $macro);

        $this->assertEquals($expected, DeviceGroup::applyGroupMacros('macros.device = 1'));
    }
}
