<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblGlobalPvLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_global_pv_logs'))
        {
            Schema::create('tbl_global_pv_logs', function (Blueprint $table)
            {
                $table->increments('global_pv_logs_id');
                $table->integer('slot_id');
                $table->double('value');
                $table->tinyInteger('done')->default(0);
                $table->timestamps();
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
        Schema::drop("tbl_global_pv_logs");
    }
}
