<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblAdminLogsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_admin_log', 'old_data'))
        {
            Schema::table('tbl_admin_log', function (Blueprint $table)
            {
                $table->longText('old_data')->nullable();
                $table->longText('new_data')->nullable();
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
