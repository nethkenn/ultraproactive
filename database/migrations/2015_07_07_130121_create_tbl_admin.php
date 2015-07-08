<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin', function (Blueprint $table) {

        $table->increments('admin_id');
        $table->integer('account_id')->unsigned();
        $table->integer('admin_position_id')->unsigned();
    });
        Schema::table('tbl_admin', function ($table) {

            //foreign key account id reference is account id from tbl account
            $table->foreign('account_id')
                ->references('account_id')
                ->on('tbl_account');


            //foreign key admin_position_id reference is admin_position_id from tbl_admin_positions
            $table->foreign('admin_position_id')
                ->references('admin_position_id')
                ->on('tbl_admin_position');
        });
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
