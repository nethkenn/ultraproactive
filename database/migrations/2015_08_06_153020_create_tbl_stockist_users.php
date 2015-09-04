<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStockistUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stockist_user', function (Blueprint $table) {
            $table->integer('stockist_id')->unsigned();
            $table->increments('stockist_user_id');
            $table->string('stockist_email');
            $table->string('stockist_un');
            $table->string('stockist_pw');
            $table->integer('level')->default(0)->unsigned();
            $table->integer('archive')->default(0)->unsigned();


            $table->foreign('stockist_id')
              ->references('stockist_id')->on('tbl_stockist')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_stockist_user');
    }
}
