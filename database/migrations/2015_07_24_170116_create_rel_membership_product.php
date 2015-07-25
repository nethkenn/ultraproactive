<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelMembershipProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               Schema::create('rel_membership_product', function (Blueprint $table)
        {
            $table->integer('slot_id')->unsigned();
            $table->integer('product_package_id')->unsigned();
            $table->foreign('slot_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
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
             Schema::drop("rel_membership_product");
    }
}
