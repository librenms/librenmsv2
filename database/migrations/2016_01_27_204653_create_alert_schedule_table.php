<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlertScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alert_schedule', function(Blueprint $table)
		{
			$table->integer('schedule_id', true);
			$table->dateTime('start')->default('0000-00-00 00:00:00');
			$table->dateTime('end')->default('0000-00-00 00:00:00');
			$table->string('title');
			$table->text('notes', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alert_schedule');
	}

}
