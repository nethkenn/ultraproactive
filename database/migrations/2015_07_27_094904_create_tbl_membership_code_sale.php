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
            $table->integer('sold_to')->unsigned()->nullable();
            $table->integer('generated_by')->unsigned()->nullable();
            $table->double('total_amount');
            $table->timestamps();


            $table->foreign('sold_to')
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
        Schema::drop('tbl_membership_code_sale');
    }
}
