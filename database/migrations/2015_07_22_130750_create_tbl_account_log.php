<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_account_log', function (Blueprint $table)
        {
            $table->increments('account_log_id');
            $table->text('account_log_details');
            $table->dateTime('account_log_date');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        Schema::drop('tbl_account_log');        
    }
}
