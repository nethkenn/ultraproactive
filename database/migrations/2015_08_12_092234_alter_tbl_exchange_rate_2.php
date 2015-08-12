<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblExchangeRate2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_exchange_rate', function (Blueprint $table) {
                $table->integer('country_id')->unsigned();
                $table->foreign('country_id')
                  ->references('country_id')->on('tbl_country')
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
        Schema::table('tbl_exchange_rate', function (Blueprint $table)
        {
        });
    }
}
