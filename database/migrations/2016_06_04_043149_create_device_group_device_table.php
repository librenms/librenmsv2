<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceGroupDeviceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_group_device', function (Blueprint $table) {
            $table->integer('device_group_id')->unsigned()->index();
            $table->integer('device_id')->unsigned()->index();
            $table->primary(['device_group_id', 'device_id']);

            $table->foreign('device_group_id')->references('id')->on('device_groups')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('device_id')->references('device_id')->on('devices')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('device_group_device');
    }

}
