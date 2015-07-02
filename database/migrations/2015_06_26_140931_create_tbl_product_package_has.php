<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProductPackageHas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_package_has', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('product_package_id')->unsigned();
            $table->integer('quantity');



            $table->foreign('product_id')
              ->references('product_id')->on('tbl_product')
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
        Schema::drop('tbl_has_product_package');
    }
}
