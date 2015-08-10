<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblStockistUserDropPwUn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_stockist', function($table)
        {
            $table->dropColumn('stockist_un');
            $table->dropColumn('stockist_email');
            $table->dropColumn('stockist_pw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
