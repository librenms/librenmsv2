<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmpMemPoolTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmpMemPool', function (Blueprint $table) {
            $table->integer('cmp_id', true);
            $table->string('Index', 8);
            $table->string('cmpName', 32);
            $table->string('cmpValid', 8);
            $table->integer('device_id')->index();
            $table->integer('cmpUsed');
            $table->integer('cmpFree');
            $table->integer('cmpLargestFree');
            $table->boolean('cmpAlternate')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cmpMemPool');
    }
}
