<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current', function (Blueprint $table) {
            $table->integer('current_id', true);
            $table->integer('device_id')->default(0)->index();
            $table->string('current_oid', 64);
            $table->string('current_index', 8);
            $table->string('current_type', 32);
            $table->string('current_descr', 32)->default('');
            $table->integer('current_precision')->default(1);
            $table->float('current_current', 10, 0)->nullable();
            $table->float('current_limit', 10, 0)->nullable();
            $table->float('current_limit_warn', 10, 0)->nullable();
            $table->float('current_limit_low', 10, 0)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('current');
    }

}
