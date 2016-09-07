<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblRedeemRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_redeem_request', function (Blueprint $table)
        {
            $table->increments('request_id');
            $table->string('request_code');
            $table->double('amount');
            $table->string('status');
            $table->tinyInteger('archived');
            $table->dateTime('request_date');
            $table->dateTime('date_claimed');
            
            
            $table->integer('slot_id')->unsigned();
    
            $table->foreign('slot_id')
              ->references('slot_id')->on('tbl_slot')
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
