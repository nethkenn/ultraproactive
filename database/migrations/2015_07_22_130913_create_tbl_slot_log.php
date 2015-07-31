<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSlotLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_slot_log', function (Blueprint $table)
        {
            $table->increments('slot_log_id');
            $table->text('slot_log_details');
            $table->double('slot_log_wallet_update');
            $table->dateTime('slot_log_date');
            $table->integer('slot_id')->unsigned();
            $table->foreign('slot_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
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
        Schema::drop('tbl_slot_log');
    }
}
