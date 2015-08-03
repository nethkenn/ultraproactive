<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_account', function (Blueprint $table) {
            $table->integer('beneficiary_id')->unsigned();

            $table->foreign('beneficiary_id')
              ->references('beneficiary_id')->on('tbl_beneficiary')
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
        Schema::table('tbl_account', function (Blueprint $table) {
            //
        });
    }
}
