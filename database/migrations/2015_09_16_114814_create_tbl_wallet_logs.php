<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWalletLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_wallet_logs', function (Blueprint $table)
        {
            $table->increments('wallet_logs_id');
            $table->double('wallet_amount');
            $table->string('keycode', 500);
            $table->integer('slot_id')->unsigned();
            $table->integer('cause_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('logs');
            $table->timestamps();

            $table->foreign('slot_id')
                  ->references('slot_id')->on('tbl_slot')
                  ->onDelete('cascade');

            $table->foreign('cause_id')
                  ->references('slot_id')->on('tbl_slot')
                  ->onDelete('cascade');

            $table->foreign('account_id')
                  ->references('account_id')->on('tbl_account')
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
