<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceGroupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_groups', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('name')->default('')->unique();
            $table->string('desc')->default('');
            $table->text('pattern')->nullable();
            $table->text('params')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('device_groups');
    }
}
