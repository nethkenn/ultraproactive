<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblMembershipSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_membership_sales', function (Blueprint $table)
        {
            $table->increments('m_sales_id');
            $table->integer('code_pin')->unsigned();
            $table->timestamps();
            $table->double('payment');
            $table->foreign('code_pin')->references('code_pin')->on('tbl_membership_code')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("tbl_membership_sales");
    }
}
