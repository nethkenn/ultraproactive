<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblMembershipCode3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership_code', function (Blueprint $table) {
            $table->integer('origin')->nullable()->unsigned();
            $table->foreign('origin')
              ->references('stockist_id')->on('tbl_stockist')
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
        Schema::table('tbl_membership_code', function (Blueprint $table) {

        });
    }
}
