<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMatchingBonus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_matching_bonus', function (Blueprint $table)
        {
            $table->integer('membership_id');
            $table->double('matching_percentage');
            $table->string('matching_requirement_count');
            $table->integer('level');
            $table->string('matching_requirement_membership_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
