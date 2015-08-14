<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTransactionProfileInput extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tbl_transaction_profile'))
        {

            Schema::create('tbl_transaction_profile_input', function (Blueprint $table)
            {
                $table->integer('profile_id')->unsigned();
                $table->integer('input_id')->unsigned();
                $table->string('value')->nullable();


                $table->foreign('profile_id')
                  ->references('id')->on('tbl_transaction_profile')
                  ->onDelete('cascade');


                                  $table->foreign('input_id')
                  ->references('id')->on('tbl_get_input')
                  ->onDelete('cascade'); 







            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_transaction_profile_input');
    }
}
