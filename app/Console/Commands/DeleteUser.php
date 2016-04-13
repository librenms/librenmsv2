<?php
/*
 * Copyright (C) 2016 Paul Heinrichs <pdheinrichs@gmail.com>
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
 * DeleteUser.php
 *
 * @package    LibreNMS
 * @author     Paul Heinrichs <pdheinrichs@gmail.com>
 * @copyright  2016 Paul Heinrichs
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete
                            {user : The user to search}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a user';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');
        $user_list = User::select('username')->where('username', 'like', '%' . $user . '%')->orWhere('realname', 'like', '%' . $user . '%')->get();
        $names = [];

        if (count($user_list) < 1) {
            $this->info('No user found.');
            return;
        }
        foreach ($user_list as $i) {
            array_push($names, $i->username);
        }
        if (count($names) > 1) {
            $name = $this->choice('Who would you like to remove?', $names);
        }
        else {
            $name = $names[0];
        }
        if ($this->confirm('Do you wish to remove ' . $name . '?')) {
            User::where('username', $name)->delete();
            $this->info('User deleted.');
        }
    }
}
