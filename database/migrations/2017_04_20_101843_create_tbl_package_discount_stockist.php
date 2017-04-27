<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPackageDiscountStockist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_package_discount_stockist', function (Blueprint $table)
        {
            $table->double('discount');
            
            $table->integer('product_package_id')->unsigned();
            $table->foreign('product_package_id')->references('product_package_id')->on('tbl_product_package')->onDelete('cascade');
            
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
