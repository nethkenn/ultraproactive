<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblPackageUpCoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_product_package', function (Blueprint $table)
        {
            $table->double('product_package_upcoin')->default(0);
        });
        
        Schema::table('tbl_membership_code', function (Blueprint $table)
        {
            $table->double('membership_code_upcoin')->default(0);
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
