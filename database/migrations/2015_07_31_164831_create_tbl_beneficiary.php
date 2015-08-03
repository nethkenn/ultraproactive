<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBeneficiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_beneficiary', function (Blueprint $table) {
            $table->increments('beneficiary_id');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('m_name');
            $table->tinyInteger('gender');
            $table->integer('beneficiary_rel_id')->unsigned();


            $table->foreign('beneficiary_rel_id')
              ->references('beneficiary_rel_id')->on('tbl_beneficiary_rel')
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
        Schema::drop('tbl_beneficiary');
    }
}
