<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMindsync extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_mindsync', function (Blueprint $table)
        {
            $table->increments('mindsync_id');
            $table->string('mindsync_title');
            $table->string('mindsync_video');
            $table->string('mindsync_image');
            $table->text('mindsync_description');
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
        Schema::drop('tbl_mindsync');
    }
}
