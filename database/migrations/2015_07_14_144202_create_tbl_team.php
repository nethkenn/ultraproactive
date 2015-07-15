<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_team', function (Blueprint $table)
        {
            $table->increments('team_id');
            $table->string('team_title');
            $table->string('team_role');
            $table->text('team_description');
            $table->string('team_image')->default('default.jpg');
            $table->timestamps();
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
        Schema::drop('tbl_team');
    }
}
