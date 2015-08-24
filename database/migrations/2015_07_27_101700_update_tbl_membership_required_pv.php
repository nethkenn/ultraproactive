<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMembershipRequiredPv extends Migration
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
            $table->double('membership_required_pv')->default(0);
            $table->double('membership_daily_pairing_limit')->default(0);
            $table->double('membership_required_upgrade')->default(0);
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
            $table->dropColumn('membership_required_pv');
            $table->dropColumn('membership_daily_pairing_limit');
            $table->dropColumn('membership_required_upgrade');
        });
    }
}
