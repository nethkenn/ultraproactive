<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStockistInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stockist_inventory', function (Blueprint $table) {
            $table->integer('stockist_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('stockist_quantity');
            $table->integer('archived');


            $table->foreign('stockist_id')
              ->references('stockist_id')->on('tbl_stockist')
              ->onDelete('cascade');

            $table->foreign('product_id')
              ->references('product_id')->on('tbl_product')
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
       Schema::drop('tbl_stockist_inventory');
    }
}
