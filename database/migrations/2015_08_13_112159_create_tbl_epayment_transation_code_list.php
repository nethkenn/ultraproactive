<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEpaymentTransationCodeList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_epayment_transation_code_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_code')->unique();
            $table->string('description');
            $table->tinyInteger('archived')->default(0);
            $table->tinyInteger('front')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_epayment_transation_code_list');
    }
}
