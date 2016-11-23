<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->integer('device_id', true, true);
            $table->string('hostname', 128)->index();
            $table->string('sysName', 128)->nullable()->index();
            $table->binary('ip', 16);
            $table->string('community')->nullable();
//			$table->enum('authlevel', array('noAuthNoPriv','authNoPriv','authPriv'))->nullable();
            $table->string('authlevel')->nullable();
            $table->string('authname', 64)->nullable();
            $table->string('authpass', 64)->nullable();
//			$table->enum('authalgo', array('MD5','SHA'))->nullable();
            $table->string('authalgo')->nullable();
            $table->string('cryptopass', 64)->nullable();
//			$table->enum('cryptoalgo', array('AES','DES'))->nullable();
            $table->string('cryptoalgo')->nullable();
            $table->string('snmpver', 4)->default('v2c');
            $table->smallInteger('port')->unsigned()->default(161);
            $table->string('transport', 16)->default('udp');
            $table->integer('timeout')->nullable();
            $table->integer('retries')->nullable();
            $table->string('bgpLocalAs', 16)->nullable();
            $table->string('sysObjectID', 64)->nullable();
            $table->text('sysDescr', 65535)->nullable();
            $table->text('sysContact', 65535)->nullable();
            $table->text('version', 65535)->nullable();
            $table->text('hardware', 65535)->nullable();
            $table->text('features', 65535)->nullable();
            $table->text('location', 65535)->nullable();
            $table->string('os', 32)->nullable()->index();
            $table->boolean('status')->default(0)->index();
            $table->string('status_reason', 50);
            $table->boolean('ignore')->default(0);
            $table->boolean('disabled')->default(0);
            $table->bigInteger('uptime')->nullable();
            $table->integer('agent_uptime')->default(0);
            $table->dateTime('last_polled')->nullable()->index();
            $table->dateTime('last_poll_attempted')->nullable()->index();
            $table->float('last_polled_timetaken', 5)->nullable();
            $table->float('last_discovered_timetaken', 5)->nullable();
            $table->dateTime('last_discovered')->nullable();
            $table->dateTime('last_ping')->nullable();
            $table->float('last_ping_timetaken', 5)->nullable();
            $table->string('purpose', 64)->nullable();
            $table->string('type', 20)->default('');
            $table->text('serial', 65535)->nullable();
            $table->string('icon')->nullable();
            $table->integer('poller_group')->default(0);
            $table->boolean('override_sysLocation')->nullable()->default(0);
            $table->text('notes', 65535)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('devices');
    }
}
