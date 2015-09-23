<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblSlotDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            DB::statement('ALTER TABLE `tbl_slot` MODIFY `pairs_per_day_date` VARCHAR(100) default 0;');
            DB::statement('ALTER TABLE `tbl_slot` MODIFY `slot_today_date` VARCHAR(100) default 0; NOT NULL');

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
