<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFanspeedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fanspeed', function(Blueprint $table)
		{
			$table->integer('fan_id', true);
			$table->integer('fan_host')->default(0)->index('fan_host');
			$table->string('fan_oid', 64);
			$table->string('fan_descr', 32)->default('');
			$table->integer('fan_precision')->default(1);
			$table->integer('fan_current')->default(0);
			$table->integer('fan_limit')->default(60);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fanspeed');
	}

}
