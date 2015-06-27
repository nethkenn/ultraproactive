<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_category', function (Blueprint $table) {
            $table->increments('product_category_id');
            $table->string('product_category_name');
            $table->string('slug');
            $table->timeStamps();
            $table->tinyInteger('archived')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_product_category');
    }
}
