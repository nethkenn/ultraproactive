<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblGlobalPv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_global_pv_done'))
        {
            Schema::create('tbl_global_pv_done', function (Blueprint $table)
            {   
                $table->increments("global_pv_done_id");
                $table->dateTime('start_date');
                $table->dateTime('last_date');
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
