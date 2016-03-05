<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoltageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voltage', function(Blueprint $table)
		{
			$table->integer('volt_id', true);
			$table->integer('volt_host')->default(0)->index();
			$table->string('volt_oid', 64);
			$table->string('volt_descr', 32)->default('');
			$table->integer('volt_precision')->default(1);
			$table->integer('volt_current')->default(0);
			$table->integer('volt_limit')->default(60);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('voltage');
	}

}
