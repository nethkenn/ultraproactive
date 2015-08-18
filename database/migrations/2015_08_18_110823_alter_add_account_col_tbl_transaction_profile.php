<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAccountColTblTransactionProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_transaction_profile', function (Blueprint $table)
        {
            $table->integer('account')->unsigned()->nullable();

            $table->foreign('account')
              ->references('account_id')->on('tbl_account')
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
        Schema::table('tbl_transaction_profile', function (Blueprint $table) {
            $table->dropColumn('account');
        });
    }
}
