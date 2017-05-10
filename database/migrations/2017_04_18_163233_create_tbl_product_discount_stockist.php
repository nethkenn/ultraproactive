<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProductDiscountStockist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_discount_stockist', function (Blueprint $table)
        {
            $table->double('discount');
            
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('product_id')->on('tbl_product')->onDelete('cascade');
            
            $table->integer('stockist_id')->unsigned();
            $table->foreign('stockist_id')->references('stockist_id')->on('tbl_stockist')->onDelete('cascade');
            
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
