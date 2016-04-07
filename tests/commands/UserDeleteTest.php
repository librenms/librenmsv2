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
 * SettingsTest.php
 *
 * @package    LibreNMS
 * @author     Paul Heinrichs <pdheinrichs@gmail.com>
 * @copyright  2016 Paul Heinrichs
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */

use App\Models\User;

class UserDeleteTest extends TestCase
{
    public function testDeleteNonUser()
    {
        Artisan::call('user:delete', ['user' => 'gandalfthegrey']);

        $this->assertEquals("No user found.\n", Artisan::output());
    }

    public function testDeleteUser()
    {
        User::create(['username' => 'bilbobaggins', 'realname' => 'Billy Boyd', 'email' => 'baggins@theshire.org']);

        $username = 'bilbobaggins';

        // set up the mocks
        $mock = Mockery::mock('\App\Console\Commands\DeleteUser[argument, confirm, info]');

        $mock->shouldReceive('argument')
            ->with('user')
            ->once()
            ->andReturn($username);

        $mock->shouldReceive('confirm')
            ->with('Do you wish to remove '.$username.'?')
            ->once()
            ->andReturn('yes');

        $mock->shouldReceive('info')
            ->once();

        // call the handle function
        $mock->handle();
    }
    public function testDeleteUserChoice()
    {
        User::create(['username' => 'bilbobaggins', 'realname' => 'Billy Boyd', 'email' => 'baggins@theshire.org']);
        User::create(['username' => 'frodobaggins', 'realname' => 'Elijah Wood', 'email' => 'ringbearer@theshire.org']);
        $search = 'baggins';
        $removeUser = 'bilbobaggins';
        // set up the mocks
        $mock = Mockery::mock('\App\Console\Commands\DeleteUser[argument, choice, confirm, info]');

        $mock->shouldReceive('argument')
            ->with('user')
            ->once()
            ->andReturn($search);

        $mock->shouldReceive('choice')
            ->with("Who would you like to remove?", array(0=>'bilbobaggins',1=>'frodobaggins'), false)
            ->once()
            ->andReturn($removeUser);

        $mock->shouldReceive('confirm')
            ->with('Do you wish to remove '.$removeUser.'?')
            ->once()
            ->andReturn('yes');

        $mock->shouldReceive('info')
            ->once();

        // call the handle function
        $mock->handle();
    }
}
