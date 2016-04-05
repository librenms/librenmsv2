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
 * @author     Tony Murray <murraytony@gmail.com>
 * @copyright  2016 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */

use App\Models\User;

class UserAddTest extends TestCase
{

    public function testCreateUser()
    {
        Artisan::call('user:add', ['username' => 'jdoe', 'password' => 'p@ssw0rd', '--realname' => 'John Doe', '--email' => 'john.doe@email.com']);

        $this->assertEquals("User jdoe created.\n", Artisan::output());

        $user = User::where('username', 'jdoe')->first();
        $this->assertEquals('jdoe', $user->username);
        $this->assertEquals('John Doe', $user->realname);
        $this->assertEquals('john.doe@email.com', $user->email);

        $this->assertTrue(Auth::once(['username' => 'jdoe', 'password' => 'p@ssw0rd']));
    }

    public function testUserExists()
    {
        User::create(['username' => 'mdomo', 'realname' => 'Major Domo', 'email' => 'major@domo.edu']);
        Artisan::call('user:add', ['username' => 'mdomo']);

        $this->assertContains("User mdomo exists.", Artisan::output());
    }

    public function testMockInput() {
        $username = 'mcyrus';
        $realname = 'Miley Cyrus';
        $email = 'miley@hannahmontana.com';
        $password = 'WreckingBall01';

        // set up the mocks
        $mock = Mockery::mock('\App\Console\Commands\AddUser[option, argument, ask, secret, info]');

        $mock->shouldReceive('option')
            ->times(4)
            ->andReturn(false);

        $mock->shouldReceive('argument')
            ->with('password')
            ->once()
            ->andReturn(false);

        $mock->shouldReceive('argument')
            ->with('username')
            ->once()
            ->andReturn($username);

        $mock->shouldReceive('ask')
            ->with('Real Name')
            ->once()
            ->andReturn($realname);

        $mock->shouldReceive('ask')
            ->with('Email')
            ->once()
            ->andReturn($email);

        $mock->shouldReceive('secret')
            ->with('Password')
            ->once()
            ->andReturn($password);

        $mock->shouldReceive('info')
            ->once();

        // call the handle function
        $mock->handle();

        $user = User::find(1)->first();
        $this->assertEquals($username, $user->username);
        $this->assertEquals($realname, $user->realname);
        $this->assertEquals($email, $user->email);
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
