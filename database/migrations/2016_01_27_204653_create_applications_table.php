<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->integer('app_id', true);
            $table->integer('device_id');
            $table->string('app_type', 64);
            $table->string('app_state', 32)->default('UNKNOWN');
            $table->string('app_status', 8);
            $table->string('app_instance');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('applications');
    }

}
