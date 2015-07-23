<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMembershipCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_membership_code', function (Blueprint $table)
        {
            $table->increments('code_pin');
            $table->string('code_activation');

            $table->integer('code_type_id')->unsigned();
            $table->integer('membership_id')->unsigned();
            $table->integer('product_package_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->integer('inventory_update_type_id')->unsigned();
            $table->integer('account_id')->unsigned()->nullable();


            $table->tinyInteger('used')->default(0);
            $table->tinyInteger('lock')->default(0);
            $table->tinyInteger('archived')->default(0);
            $table->tinyInteger('blocked')->default(0);
            $table->timestamps();

            $table->foreign('account_id')->references('account_id')->on('tbl_account');
            $table->foreign('code_type_id')->references('code_type_id')->on('tbl_code_type');
            $table->foreign('membership_id')->references('membership_id')->on('tbl_membership');
            $table->foreign('product_package_id')->references('product_package_id')->on('tbl_product_package');
            $table->foreign('inventory_update_type_id')->references('inventory_update_type_id')->on('tbl_inventory_update_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_membership_code');
    }
}
