<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblSlotDistributedAndCause extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_slot', function (Blueprint $table)
        {   
                $table->tinyInteger('distributed')->default(1);
        });

        Schema::table('tbl_slot_log', function (Blueprint $table)
        {   
                $table->integer('cause_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_slot', function (Blueprint $table)
        {
            $table->dropColumn('distributed');
        });

        Schema::table('tbl_slot_log', function (Blueprint $table)
        {
            $table->dropColumn('cause_id');
        });
    }
}
