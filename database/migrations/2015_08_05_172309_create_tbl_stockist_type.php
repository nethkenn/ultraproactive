<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStockistType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stockist_type', function (Blueprint $table) {
            $table->increments('stockist_type_id');
            $table->string('stockist_type_name');
            $table->double('stockist_type_discount')->default(0);
            $table->double('stockist_type_package_discount')->default(0);
            $table->integer('stockist_type_minimum_order')->default(0);
            $table->tinyInteger('stockist_type_minimum_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_stockist_type');
    }
}
