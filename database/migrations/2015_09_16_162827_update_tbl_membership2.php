<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMembership2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_membership', 'max_group_pv'))
        {
            Schema::table('tbl_membership', function (Blueprint $table)
            {
                $table->integer('slot_limit')->default(1);
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
