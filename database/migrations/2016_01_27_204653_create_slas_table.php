<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->integer('sla_id', true);
            $table->integer('device_id')->index();
            $table->integer('sla_nr');
            $table->string('owner');
            $table->string('tag');
            $table->string('rtt_type', 16);
            $table->boolean('status');
            $table->boolean('deleted')->default(0);
            $table->unique(['device_id', 'sla_nr']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slas');
    }
}
