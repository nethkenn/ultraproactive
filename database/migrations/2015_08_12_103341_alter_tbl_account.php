<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_account', function (Blueprint $table) {
            if(Schema::hasColumn('tbl_exchange_rate', 'e_wallet'))
            {
                $table->double('e_wallet');
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
        Schema::table('tbl_account', function (Blueprint $table) {
            //
        });
    }
}
