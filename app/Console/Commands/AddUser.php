<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add 
        {username : The username to add}
        {password? : Optional}
        {--realname= : The real name of the user}
        {--email= : The email of the user}
        {--read : Global Read access}
        {--admin : Global Admin access}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user (if supported by the authentication type)';

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
        $user = new User();

        // set username
        $user->username = $this->argument('username');
        if (User::where('username', $user->username)->exists()) {
            $this->error('User '.$user->username.' exists.');
            return;
        }

        // set realname
        if ($this->option('realname')) {
            $user->realname = $this->option('realname');
        }
        else {
            $user->realname = $this->ask('Real Name');
        }

        // set email
        if ($this->option('email')) {
            $user->email = $this->option('email');
        }
        else {
            $user->email = $this->ask('Email');
        }

        // set user level, start with 1 and upgrade as specified
        $user->level = 1;
        if ($this->option('read')) {
            $user->level = 5;
        }
        if ($this->option('admin')) {
            $user->level = 10;
        }

        // set password
        if ($this->argument('password')) {
            $user->password = bcrypt($this->argument('password'));
        }
        else {
            $user->password = bcrypt($this->secret('Password'));
        }

        // save user
        if ($user->save()) {
            $this->info('User '.$user->username.' created.');
        }
        else {
            $this->error('Failed to create user '.$user->username);
        }
    }
}
