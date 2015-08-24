<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblVoucherAddIfPackage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_voucher', function (Blueprint $table)
        {
            $table->integer('multiplier')->default(0);
            $table->integer('package_id')->nullable()->unsigned();
            $table->tinyInteger('if_package')->default(0);
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
