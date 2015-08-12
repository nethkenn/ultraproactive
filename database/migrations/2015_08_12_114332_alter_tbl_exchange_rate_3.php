<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblExchangeRate3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_exchange_rate', function (Blueprint $table) {
                if(Schema::hasColumn('tbl_exchange_rate', 'country_name'))
                {
                    $table->dropColumn('country_name');
                }

                if(Schema::hasColumn('tbl_exchange_rate', 'currency'))
                {
                    $table->dropColumn('currency');
                }


                if(Schema::hasColumn('tbl_exchange_rate', 'rate'))
                {
                    $table->renameColumn('rate', 'peso_rate');
                }

                // if(Schema::hasColumn('tbl_exchange_rate', 'currency_id'))
                // {

                //     $table->dropColumn('currency_id');
                // }

                if(!Schema::hasColumn('tbl_exchange_rate', 'country_id'))
                {
                    $table->integer('country_id')->unsigned();
                    $table->foreign('country_id')
                      ->references('country_id')->on('tbl_country')
                      ->onDelete('cascade');
                }


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
