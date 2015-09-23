<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblTransactionGpvPv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_transaction', 'earned_gpv'))
        {
            Schema::table('tbl_transaction', function (Blueprint $table)
            {
                $table->double('earned_gpv')->default(0);
                $table->double('earned_pv')->default(0);
                $table->integer('transaction_slot_id')->unsigned()->nullable();
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
