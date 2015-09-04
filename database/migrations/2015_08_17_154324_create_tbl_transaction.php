<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaction', function (Blueprint $table) {
            $table->increments('transaction_id')->unsigned();
            $table->string('transaction_description');
            $table->double('transaction_amount');
            $table->double('transaction_discount_percentage');
            $table->double('transaction_discount_amount');
            $table->double('transaction_total_amount');
            $table->tinyInteger('transaction_paid');
            $table->tinyInteger('transaction_claimed');
            $table->tinyInteger('archived');
            $table->string('transaction_by');
            $table->string('transaction_to');
            $table->string('transaction_payment_type');
            $table->integer('transaction_by_stockist_id')->nullable()->unsigned();
            $table->integer('transaction_to_id')->nullable()->unsigned();
            $table->string('extra');
            $table->integer('voucher_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('tbl_transaction');
    }
}
