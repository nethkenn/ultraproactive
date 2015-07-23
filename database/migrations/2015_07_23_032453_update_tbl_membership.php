<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership', function (Blueprint $table)
        {
            /* NEW COLUMN FOR COMPUTATITION */
            $table->double('membership_binary_points')->default(0);
            $table->tinyInteger('membership_entry')->default(1);
            $table->tinyInteger('membership_upgrade')->default(1);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_membership', function($table)
        {
            $table->dropColumn('membership_binary_points');
            $table->dropColumn('membership_entry');
            $table->dropColumn('membership_upgrade');
        });
    }
}
