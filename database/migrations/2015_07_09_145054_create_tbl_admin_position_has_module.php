<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAdminPositionHasModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_position_has_module', function (Blueprint $table) {
            $table->integer('admin_postion_id')->unsigned;
            $table->integer('module_id')->unsigned;

            $table->foreign('admin_postion_id')->references('admin_postion_id')->on('tbl_admin_position');
            $table->foreign('module_id')->references('module_id')->on('tbl_module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_admin_position_has_module');
    }
}
