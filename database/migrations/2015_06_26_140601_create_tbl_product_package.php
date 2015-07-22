<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProductPackage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_package', function (Blueprint $table) {
            $table->increments('product_package_id');
            $table->string('product_package_name');
            $table->tinyInteger('archived');
            $table->string('slug');
            $table->integer('membership_id')->unsigned();

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
        Schema::drop('tbl_product_package');
    }
}
