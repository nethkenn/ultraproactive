<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLeadershipBonus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_leadership_bonus', function (Blueprint $table)
        {
            $table->increments('leadership_bonus_id');
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
      Schema::drop("tbl_leadership_bonus");
    }
}
