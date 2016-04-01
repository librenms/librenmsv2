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
        $headers = ['ID','username','realname','email'];
        $user = $this->argument('user');
        $user_list = User::select('user_id','username','realname','email')->where('username', 'like', '%'.$user.'%')->orWhere('realname','like', '%'.$user.'%')->get()->toArray();
        $this->table($headers,$user_list);

        $userid = $this->ask('Enter the ID you wish to remove');
        $remove_user = User::find($userid);
        if ($this->confirm('Do you wish to remove '.$remove_user->realname.'? [y|N]')) {
            $remove_user->delete();
        }
    }
}
