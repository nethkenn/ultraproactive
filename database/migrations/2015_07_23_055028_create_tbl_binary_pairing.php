<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBinaryPairing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_binary_pairing', function (Blueprint $table)
        {
            $table->increments('pairing_id');
            $table->double('pairing_point_l');
            $table->double('pairing_point_r');
            $table->double('pairing_income');
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
        Schema::drop('tbl_binary_pairing');
    }
}
