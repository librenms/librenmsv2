<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventlog', function(Blueprint $table)
		{
			$table->integer('event_id', true);
			$table->integer('host')->default(0)->index();
            $table->dateTime('datetime')->useCurrent()->index();
			$table->text('message', 65535)->nullable();
			$table->string('type', 64)->nullable();
			$table->string('reference', 64);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('eventlog');
	}

}
