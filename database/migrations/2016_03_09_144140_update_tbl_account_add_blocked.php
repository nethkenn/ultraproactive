<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblAccountAddBlocked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_account', function (Blueprint $table) {
            $table->tinyInteger('blocked')->default(0);
            $table->dateTime('blocked_date')->nullable();
            $table->integer('blocked_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_account', function (Blueprint $table) {
            $table->dropColumn('blocked');
            $table->dropColumn('blocked_date');
            $table->dropColumn('blocked_by');
        });
    }
}
