<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTravelBonus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_travel_reward', function (Blueprint $table)
        {
            $table->increments('travel_reward_id');
            $table->string('travel_reward_name');
            $table->double('required_points');
            $table->tinyInteger('archived')->default(0);
        });

        Schema::create('tbl_travel_qualification', function (Blueprint $table)
        {
            $table->increments('travel_qualification_id');
            $table->string('travel_qualification_name');
            $table->integer('item');
            $table->double('points');
            $table->tinyInteger('archived')->default(0);
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
        Schema::drop('tbl_travel_qualification');
    }
}
