<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblProductIntToDouble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            DB::statement('ALTER TABLE `tbl_product` MODIFY `upgrade_pts` double default 0 NOT NULL;');
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
