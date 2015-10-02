<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblProductPackageBinaryPoints extends Migration
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
            $table->double('package_binary_points')->default(0);
        });

        Schema::table('tbl_product_code', function (Blueprint $table)
        {
            $table->string('code_package_name')->nullable();
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
