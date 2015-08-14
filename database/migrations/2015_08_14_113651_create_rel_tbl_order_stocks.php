<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelTblOrderStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_order_stocks', function (Blueprint $table) {
            $table->integer('order_stocks_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');

            $table->foreign('order_stocks_id')
              ->references('order_stocks_id')->on('tbl_order_stocks')
              ->onDelete('cascade');

            $table->foreign('product_id')
              ->references('product_id')->on('tbl_product')
              ->onDelete('cascade');
        });   

        Schema::create('rel_order_stocks_package', function (Blueprint $table) {
            $table->integer('order_stocks_id')->unsigned();
            $table->integer('product_package_id')->unsigned();
            $table->integer('quantity');

            $table->foreign('order_stocks_id')
              ->references('order_stocks_id')->on('tbl_order_stocks')
              ->onDelete('cascade');

            $table->foreign('product_package_id')
              ->references('product_package_id')->on('tbl_product_package')
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
        //
    }
}
