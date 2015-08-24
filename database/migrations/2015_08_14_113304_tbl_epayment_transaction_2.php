<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblEpaymentTransaction2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_epayment_transaction', function (Blueprint $table) {
            $table->integer('agentRefNo')->unsigned();
            $table->integer('country')->unsigned();
            $table->integer('account')->unsigned();
            
            $table->string('transaction');
            $table->double('rate_peso')->default(0);
            $table->double('service_charge')->default(0);
            
            $table->double('amount')->default(0);
            $table->double('total_amount')->default(0);
            $table->double('e_wallet')->default(0);
            $table->double('e_wallet_less_total')->default(0);
            $table->timestamps();

            $table->foreign('agentRefNo')
              ->references('agentRefNo')->on('tbl_agentRefNo')
              ->onDelete('cascade');
            $table->foreign('country')
              ->references('country_id')->on('tbl_country')
              ->onDelete('cascade');

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
        Schema::drop('tbl_epayment_transaction');
    }
}
