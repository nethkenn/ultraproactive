<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblWalletLogsWalletType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_wallet_logs', 'wallet_type'))
        {
            Schema::table('tbl_wallet_logs', function (Blueprint $table)
            {
                $table->string('wallet_type')->default('Wallet');
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
        //
    }
}
