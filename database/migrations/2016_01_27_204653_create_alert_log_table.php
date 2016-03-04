<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlertLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alert_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('rule_id')->index();
			$table->integer('device_id')->index();
			$table->integer('state');
			$table->binary('details');
			$table->timestamp('time_logged')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alert_log');
	}

}
