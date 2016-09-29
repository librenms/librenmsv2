<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVminfoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vminfo', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('device_id')->index();
            $table->string('vm_type', 16)->default();
            $table->integer('vmwVmVMID')->index();
            $table->string('vmwVmDisplayName', 128);
            $table->string('vmwVmGuestOS', 128);
            $table->integer('vmwVmMemSize');
            $table->integer('vmwVmCpus');
            $table->string('vmwVmState', 128);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vminfo');
    }

}
