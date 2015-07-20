<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMemberCodeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_member_code_history', function (Blueprint $table) {

            $table->integer('code_pin')->unsigned();
            $table->integer('by_account_id')->unsigned();
            $table->integer('to_account_id')->unsigned();
            $table->dateTime('updated_at');
            $table->text('description');
            
            $table->foreign('by_account_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
            $table->foreign('to_account_id')->references('account_id')->on('tbl_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_member_code_history');
    }
}
