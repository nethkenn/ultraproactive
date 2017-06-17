<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItemPackagesV8776 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_item_packages', function (Blueprint $table) {
            $table->increments('item_package_id');
            $table->string('item_package_title');
            $table->text('item_package_image');
            $table->datetime('created_at');
            $table->tinyInteger('archived');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_item_packages');
    }
}
