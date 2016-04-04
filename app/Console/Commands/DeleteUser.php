<?php

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
     *
     * @return void
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
        $user_list = User::select('username')->where('username', 'like', '%'.$user.'%')->orWhere('realname','like', '%'.$user.'%')->get();
        $names = [];
        foreach ($user_list as $i) {
            array_push($names,$i->username);
        }
        if (count($names) > 1) {
            $name = $this->choice('Who would you like to remove?',$names, false);
        }
        else {
            $name = $names[0];
        }
        if ($this->confirm('Do you wish to remove '.$name.'?')) {
            $remove_user = User::select('user_id')->where('username', $name)->delete();
            $this->info('User deleted.');
        }
    }
}
