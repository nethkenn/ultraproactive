<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStockist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stockist', function (Blueprint $table) {
            $table->increments('stockist_id');
            $table->string('stockist_full_name');
            $table->integer('stockist_type')->unsigned();
            $table->string('stockist_location');
            $table->string('stockist_address');
            $table->string('stockist_contact_no');
            // $table->string('stockist_email');
            // $table->string('stockist_un');
            // $table->string('stockist_pw');
            $table->tinyInteger('archive')->default(0);
            $table->timestamps();
            
            $table->foreign('stockist_type')
              ->references('stockist_type_id')->on('tbl_stockist_type')
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
        Schema::drop('tbl_stockist');
    }
}
