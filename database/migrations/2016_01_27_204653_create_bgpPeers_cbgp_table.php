<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBgpPeersCbgpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bgpPeers_cbgp', function(Blueprint $table)
		{
			$table->integer('device_id');
			$table->string('bgpPeerIdentifier', 64);
			$table->string('afi', 16);
			$table->string('safi', 16);
			$table->integer('AcceptedPrefixes');
			$table->integer('DeniedPrefixes');
			$table->integer('PrefixAdminLimit');
			$table->integer('PrefixThreshold');
			$table->integer('PrefixClearThreshold');
			$table->integer('AdvertisedPrefixes');
			$table->integer('SuppressedPrefixes');
			$table->integer('WithdrawnPrefixes');
			$table->unique(['device_id','bgpPeerIdentifier','afi','safi'], 'unique_index');
			$table->index(['device_id','bgpPeerIdentifier'], 'device_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bgpPeers_cbgp');
	}

}
