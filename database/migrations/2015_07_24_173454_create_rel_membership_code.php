<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelMembershipCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               Schema::create('rel_membership_code', function (Blueprint $table)
        {
            $table->integer('code_pin')->unsigned();
            $table->integer('product_package_id')->unsigned();
            $table->foreign('code_pin')->references('code_pin')->on('tbl_membership_code')->onDelete('cascade');
            $table->foreign('product_package_id')->references('product_package_id')->on('tbl_product_package')->onDelete('cascade');            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
             Schema::drop("rel_membership_code");
    }
}
