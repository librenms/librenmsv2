<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class dbSchemaTableSeeder extends Seeder
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
