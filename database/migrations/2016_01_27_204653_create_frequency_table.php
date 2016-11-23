<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFrequencyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequency', function (Blueprint $table) {
            $table->integer('freq_id', true);
            $table->integer('device_id')->default(0)->index();
            $table->string('freq_oid', 64);
            $table->string('freq_index', 8);
            $table->string('freq_type', 32);
            $table->string('freq_descr', 32)->default('');
            $table->integer('freq_precision')->default(1);
            $table->float('freq_current', 10, 0)->nullable();
            $table->float('freq_limit', 10, 0)->nullable();
            $table->float('freq_limit_low', 10, 0)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('frequency');
    }
}
