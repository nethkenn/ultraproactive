<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditArchivedTblStockistInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_stockist_inventory', function (Blueprint $table) {
            $table->integer('stockist_quantity')->default(0)->change();
            DB::statement('ALTER TABLE `tbl_stockist_inventory` MODIFY `archived` TINYINT UNSIGNED NOT NULL;');
            DB::statement("ALTER TABLE tbl_stockist_inventory ALTER archived SET DEFAULT '0'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_stockist_inventory', function (Blueprint $table) {
            //
        });
    }
}
