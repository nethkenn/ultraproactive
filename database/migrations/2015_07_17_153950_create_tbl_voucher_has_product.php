<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblVoucherHasProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_voucher_has_product', function (Blueprint $table) {
                
            $table->increments('voucher_item_id');
            $table->integer('product_id')->unsigned();
            $table->integer('voucher_id')->unsigned();
            $table->double('price');
            $table->integer('qty')->unsigned();
            $table->double('sub_total');
            $table->double('unilevel_pts');
            $table->double('binary_pts');


            $table->foreign('product_id')
                ->references('product_id')
                ->on('tbl_product')
                ->onDelete('cascade');


                            $table->foreign('voucher_id')
                ->references('voucher_id')
                ->on('tbl_voucher')
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
        Schema::drop('tbl_voucher_has_product');
    }
}
