<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_transaction', function (Blueprint $table) {
            $table->increments('rel_transaction_id');
            $table->integer('transaction_id')->unsigned();

            $table->integer('if_product')->default(0);
            $table->integer('if_product_package')->default(0);
            $table->integer('if_code_pin')->default(0);           

            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('product_package_id')->nullable()->unsigned();
            $table->integer('code_pin')->nullable()->unsigned();

            $table->double('transaction_amount');
            $table->integer('transaction_qty');
            $table->double('transaction_total');

            $table->string('rel_transaction_log');
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
