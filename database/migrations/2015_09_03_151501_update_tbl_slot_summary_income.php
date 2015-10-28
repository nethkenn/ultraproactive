<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblSlotSummaryIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_slot', 'total_earned_binary'))
        {
            Schema::table('tbl_slot', function (Blueprint $table)
            {
                $table->double('total_earned_binary')->default(0);
                $table->double('total_earned_matching')->default(0);
                $table->double('total_earned_direct')->default(0);
                $table->double('total_earned_indirect')->default(0);
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
