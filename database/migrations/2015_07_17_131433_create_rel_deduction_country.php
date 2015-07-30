<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelDeductionCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
            Schema::create('rel_deduction_country', function (Blueprint $table) 
            {

            $table->integer('deduction_id')->unsigned();
            $table->integer('country_id')->unsigned();

            $table->foreign('country_id')->references('country_id')->on('tbl_country')->onDelete('cascade');
            $table->foreign('deduction_id')->references('deduction_id')->on('tbl_deduction')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_deduction_country');
    }
}
