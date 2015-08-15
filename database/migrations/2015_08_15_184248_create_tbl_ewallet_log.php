<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEwalletLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_e_wallet_log', function (Blueprint $table)
        {
            $table->increments('e_wallet_log_id');
            $table->integer('account')->nullable()->unsigned();
            $table->string('e_wallet_details');
            $table->double('e_wallet_update')->nullable();
            $table->string('e_wallet_log_key');
            $table->timestamps();

            $table->foreign('account')
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
        Schema::drop('tbl_ewallet_log');
    }
}
