<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ConfigNameUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config', function (Blueprint $table) {
            $table->unique('config_name', 'config_config_name_unique');
            $table->string('config_value', 512)->nullable()->change();
            $table->string('config_default')->nullable()->change();
            $table->string('config_descr', 100)->nullable()->change();
            $table->string('config_group', 50)->nullable()->change();
            $table->integer('config_group_order')->nullable()->change();
            $table->string('config_sub_group', 50)->nullable()->change();
            $table->integer('config_sub_group_order')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config', function (Blueprint $table) {
            $table->dropUnique('config_config_name_unique');
            $table->string('config_value', 512)->change();
            $table->string('config_default', 512)->change();
            $table->string('config_descr', 100)->change();
            $table->string('config_group', 50)->change();
            $table->integer('config_group_order')->change();
            $table->string('config_sub_group', 50)->change();
            $table->integer('config_sub_group_order')->change();
        });
    }
}
