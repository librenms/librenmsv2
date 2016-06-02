<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceGroupDevicePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function($table) {
            $table->integer('device_id', true)->unsigned()->change();
        });

        Schema::table('device_groups', function($table) {
            $table->integer('id', true)->unsigned()->change();
        });

        Schema::create('device_group_device', function(Blueprint $table) {
            $table->integer('device_group_id')->index();
            $table->foreign('device_group_id')->references('id')->on('device_groups')->onDelete('cascade');
            $table->integer('device_id')->unsigned()->index();
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade');
            $table->primary(['device_group_id', 'device_id']);
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

        Schema::table('devices', function($table) {
            $table->integer('device_id', true)->change();
        });

        Schema::table('device_groups', function($table) {
            $table->integer('id', true)->change();
        });
    }
}
