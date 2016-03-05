<?php

use Illuminate\Database\Seeder;

class DbSchemaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['version' => 100];
        DB::table('dbSchema')->insert($data);
    }
}
