<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblAccountExpired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_account', 'account_expired'))
        {
            Schema::table('tbl_account', function (Blueprint $table)
            {
                $table->tinyInteger('account_expired')->default(0);
                $table->tinyInteger('account_approved')->default(1);
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
