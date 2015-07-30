<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUnilevelSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_unilevel_setting', function (Blueprint $table)
        {
            $table->increments('indirect_seting_id');
            $table->integer('level');
            $table->double('value');
            $table->integer('membership_id')->unsigned();
            $table->foreign('membership_id')->references('membership_id')->on('tbl_membership');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("tbl_unilevel_setting");
    }
}
