<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblResponseData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_response_data', function (Blueprint $table) {
            $table->integer('agentRefNo')->unsigned();
            $table->string('data_name')->nullable();
            $table->string('data_value')->nullable;
            $table->foreign('agentRefNo')
              ->references('agentRefNo')->on('tbl_agentRefNo')
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
        Schema::drop('tbl_response_data');
    }
}
