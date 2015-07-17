<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table)
        {
            $table->increments('product_id');
            $table->string('sku');
            // $table->string('barcode');
            $table->string('product_name');
            $table->text('product_info');
            $table->string('slug');
            $table->integer('product_category_id')->unsigned();
            $table->double('unilevel_pts')->default(0);
            $table->double('binary_pts')->default(0);
            $table->double('price')->default(0);
            $table->string('image_file')->default('default.jpg');
            $table->timestamps();
            $table->tinyInteger('archived')->default(0);
            $table->foreign('product_category_id')->references('product_category_id')->on('tbl_product_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_product');
    }
}
