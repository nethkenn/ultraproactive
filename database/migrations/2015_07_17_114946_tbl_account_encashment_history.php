<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblAccountEncashmentHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('tbl_account_encashment_history', function (Blueprint $table) {

            $table->integer('slot_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->double('amount');
            $table->dateTime('encashment_date');
            $table->double('deduction');
            $table->string('type');
            $table->string('status');
            $table->foreign('slot_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
            $table->foreign('account_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_account_encashment_history');
    }
}
