<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_voucher', function (Blueprint $table) {
            $table->integer('slot_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->increments('voucher_id');
            $table->string('voucher_code');
            $table->tinyInteger('claimed')->default(0);
            $table->double('total_amount');
            $table->timestamps();  
            $table->foreign('slot_id')
                ->references('slot_id')
                ->on('tbl_slot')
                ->onDelete('cascade');
                            $table->foreign('account_id')
                ->references('account_id')
                ->on('tbl_account')
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
        Schema::drop('tbl_voucher');
    }
}
