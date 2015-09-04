<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStockistLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stockist_log', function (Blueprint $table) {
            $table->integer('stockist_id')->unsigned();
            $table->integer('stockist_user_id')->unsigned();
            $table->string('stockist_log');

            $table->foreign('stockist_id')
              ->references('stockist_id')->on('tbl_stockist')
              ->onDelete('cascade');

            $table->foreign('stockist_user_id')
              ->references('stockist_user_id')->on('tbl_stockist_user')
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
        //
    }
}
