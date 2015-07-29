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
            $table->increments('id');
            $table->integer('admin_position_id')->unsigned();
                    $table  ->foreign('admin_position_id')
                    ->references('admin_position_id')
                    ->on('tbl_admin_position')
                    ->onDelete('cascade');

            $table->integer('module_id')->unsigned();


                                    $table  ->foreign('module_id')
                    ->references('module_id')
                    ->on('tbl_module')
                    ->onDelete('cascade');
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
