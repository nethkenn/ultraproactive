<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStockistPackageInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stockist_package_inventory', function (Blueprint $table) {
            $table->integer('stockist_id')->unsigned();
            $table->integer('product_package_id')->unsigned();
            $table->integer('package_quantity');
            $table->integer('archived');


            $table->foreign('stockist_id')
              ->references('stockist_id')->on('tbl_stockist')
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
        Schema::drop('tbl_stockist_package_inventory');
    }
}
