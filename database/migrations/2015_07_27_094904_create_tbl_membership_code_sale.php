<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMembershipCodeSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_membership_code_sale', function (Blueprint $table) {
            $table->increments('membershipcode_or_num');
            $table->string('membershipcode_or_code');
            $table->integer('voucher_id')->unsigned()->nullable();
            $table->integer('sold_to')->unsigned()->nullable();
            $table->integer('generated_by')->unsigned()->nullable();
            $table->string('generated_by_name');
            $table->tinyInteger('payment')->default(0); // 0 -wallet, 1 - cash
            $table->double('total_amount');
            $table->timestamps();


            $table->foreign('sold_to')
              ->references('account_id')->on('tbl_account')
              ->onDelete('cascade');


            $table->foreign('generated_by')
              ->references('account_id')->on('tbl_account')
              ->onDelete('cascade');


            $table->foreign('voucher_id')
              ->references('voucher_id')->on('tbl_voucher')
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
        Schema::drop('tbl_membership_code_sale');
    }
}
