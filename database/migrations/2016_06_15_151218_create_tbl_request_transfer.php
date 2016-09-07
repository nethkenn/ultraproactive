<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblRequestTransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_request_transfer_slot', function (Blueprint $table)
        {
            $table->increments('transfer_id');
            $table->integer('owner_account_id')->unsigned();
            $table->integer('owner_slot_id')->unsigned();
            $table->integer('transfer_to_account_id')->unsigned();
            $table->tinyInteger('transfer_status');
            $table->tinyInteger('archived');
            $table->dateTime('transfer_date');
            
            $table->foreign('owner_account_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
            $table->foreign('owner_slot_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
            $table->foreign('transfer_to_account_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
