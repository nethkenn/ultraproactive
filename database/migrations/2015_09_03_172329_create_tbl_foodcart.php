<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFoodcart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_foodcart', function (Blueprint $table)
        {
            $table->increments('foodcart_id');
            $table->string('foodcart_title');
            $table->string('foodcart_image')->default('default.jpg');
            $table->timestamps();
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
        Schema::drop('tbl_foodcart');
    }
}
