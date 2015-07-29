<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProductCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_code', function (Blueprint $table) {
            $table->increments('product_pin');
            $table->string('code_activation');
            $table->integer('log_id')->unsigned();
            $table->integer('voucher_item_id')->unsigned();
            


           



            $table->tinyInteger('used')->default(0);
            $table->tinyInteger('lock')->default(0);
            $table->tinyInteger('archived')->default(0);
            $table->timestamps();

            $table->foreign('voucher_item_id')->references('voucher_item_id')->on('tbl_voucher_has_product')->onDelete('cascade');
            // $table->foreign('code_type_id')->references('code_type_id')->on('tbl_code_type');
            // $table->foreign('membership_id')->references('membership_id')->on('tbl_membership');
            // $table->foreign('product_package_id')->references('product_package_id')->on('tbl_product_package');
            // $table->foreign('inventory_update_type_id')->references('inventory_update_type_id')->on('tbl_inventory_update_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_product_code');
    }
}
