<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferWallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_request_transfer_wallet', function (Blueprint $table) {
            $table->increments('transfer_id');
            $table->integer('sent_by');
            $table->integer('received_by');
            $table->integer('sent_slot_by');
            $table->integer('received_slot_by');
            $table->double('amount');
            $table->double('done');
            $table->double('cancelled');
            $table->date('date');
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
        //
    }
}
