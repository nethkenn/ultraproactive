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
            $table->double('membership_matching_bonus')->default(0);
            $table->double('membership_direct_sponsorship_bonus')->default(0);
            $table->integer('membership_indirect_level')->default(0);
            $table->integer('membership_repurchase_level')->default(0);
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
            $table->dropColumn('membership_matching_bonus');
            $table->dropColumn('membership_direct_sponsorship_bonus');
            $table->dropColumn('membership_indirect_level');
            $table->dropColumn('membership_repurchase_level');
            $table->dropColumn('membership_entry');
            $table->dropColumn('membership_upgrade');
        });
    }
}
