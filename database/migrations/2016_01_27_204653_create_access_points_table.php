<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccessPointsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('access_points', function(Blueprint $table)
		{
			$table->integer('accesspoint_id', true);
			$table->integer('device_id');
			$table->string('name');
			$table->boolean('radio_number')->nullable();
			$table->string('type', 16);
			$table->string('mac_addr', 24);
			$table->boolean('deleted')->default(0)->index('deleted');
			$table->boolean('channel')->default(0);
			$table->boolean('txpow')->default(0);
			$table->boolean('radioutil')->default(0);
			$table->smallInteger('numasoclients')->default(0);
			$table->smallInteger('nummonclients')->default(0);
			$table->boolean('numactbssid')->default(0);
			$table->boolean('nummonbssid')->default(0);
			$table->boolean('interference');
			$table->index(['name','radio_number'], 'name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('access_points');
	}

}
