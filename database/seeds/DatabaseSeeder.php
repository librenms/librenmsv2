<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

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

        $this->call(WidgetSeeder::class);
        $this->call(DbSchemaTableSeeder::class);
//        $this->call(InsertDevicesTableSeeder::class);
//        $this->call(InsertPortsTableSeeder::class);

        Model::reguard();
    }
}
