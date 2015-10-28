<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProductDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_discount', function (Blueprint $table)
        {
            $table->double('discount');
            $table->integer('product_id')->unsigned();
            $table->integer('membership_id')->unsigned();

            $table->foreign('product_id')
                  ->references('product_id')->on('tbl_product')
                  ->onDelete('cascade');

            $table->foreign('membership_id')
                  ->references('membership_id')->on('tbl_membership')
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
        Schema::drop('tbl_product_discount');
    }
}
