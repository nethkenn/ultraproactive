<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAdminLogUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_log_url', function (Blueprint $table)
        {
            $table->increments('admin_log_url_id');
            $table->integer('account_id')->unsigned();
            $table->string('logs_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("tbl_admin_log_url");
    }
}
