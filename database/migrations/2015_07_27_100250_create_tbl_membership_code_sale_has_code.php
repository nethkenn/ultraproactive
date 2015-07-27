<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMembershipCodeSaleHasCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_membership_code_sale_has_code', function (Blueprint $table) {
            
            $table->integer('membershipcode_or_num')->unsigned();
            $table->integer('code_pin')->unsigned(); 

            $table->foreign('code_pin')
              ->references('code_pin')->on('tbl_membership_code')
              ->onDelete('cascade');


            $table->foreign('membershipcode_or_num')
              ->references('membershipcode_or_num')->on('tbl_membership_code_sale')
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
        Schema::drop('tbl_membership_code_sale_has_code');
    }
}
