<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblAgentRefNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agentRefNo', function (Blueprint $table) {
            $table->increments('agentRefNo');
            $table->string('transaction_code');
            $table->string('responseCode')->nullable();
            $table->string('remarks')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();

            
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_agentRefNo');
    }
}
