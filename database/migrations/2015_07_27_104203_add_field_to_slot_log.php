<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToSlotLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_slot_log', function (Blueprint $table)
        {
            $table->string('slot_log_key')->default("OTHERS");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_slot_log', function (Blueprint $table)
        {
            $table->dropColumn('slot_log_key');
        });
    }
}
