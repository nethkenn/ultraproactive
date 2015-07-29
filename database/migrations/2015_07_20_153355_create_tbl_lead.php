<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lead', function (Blueprint $table) {
            $table->integer('lead_account_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->dateTime('join_date');

            $table->foreign('lead_account_id')
                  ->references('account_id')
                  ->on('tbl_account')
                  ->onDelete('cascade');

            $table->foreign('account_id')
                  ->references('account_id')
                  ->on('tbl_account')
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
        Schema::drop('tbl_lead');
    }
}
