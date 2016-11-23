<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBgpPeersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgpPeers', function (Blueprint $table) {
            $table->integer('bgpPeer_id', true);
            $table->integer('device_id')->index();
            $table->string('astext', 64);
            $table->text('bgpPeerIdentifier', 65535);
            $table->bigInteger('bgpPeerRemoteAs');
            $table->text('bgpPeerState', 65535);
            $table->text('bgpPeerAdminStatus', 65535);
            $table->text('bgpLocalAddr', 65535);
            $table->text('bgpPeerRemoteAddr', 65535);
            $table->integer('bgpPeerInUpdates');
            $table->integer('bgpPeerOutUpdates');
            $table->integer('bgpPeerInTotalMessages');
            $table->integer('bgpPeerOutTotalMessages');
            $table->integer('bgpPeerFsmEstablishedTime');
            $table->integer('bgpPeerInUpdateElapsedTime');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bgpPeers');
    }
}
