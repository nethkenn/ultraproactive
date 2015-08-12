<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblExchangeRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_exchange_rate', function (Blueprint $table) {
                $table->dropColumn('country_name');
                $table->dropColumn('currency');
                $table->renameColumn('rate', 'peso_rate');
                $table->renameColumn('currency_id', 'country_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_exchange_rate', function (Blueprint $table) {
            //
        });
    }
}
