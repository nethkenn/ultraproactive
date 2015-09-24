<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBreakawayBonusSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_breakaway_bonus_setting', function (Blueprint $table)
        {
            $table->increments('breakaway_bonus_setting_id');
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
        Schema::drop('tbl_breakaway_bonus_setting');
    }
}
