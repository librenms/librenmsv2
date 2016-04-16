<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // allow all values to be inserted
        Model::unguard();

        $this->call(DbSchemaTableSeeder::class);
        $this->call(InsertDevicesTableSeeder::class);
        $this->call(InsertPortsTableSeeder::class);
        $this->call(DashboardSeeder::class);

        Model::reguard();
    }
}
