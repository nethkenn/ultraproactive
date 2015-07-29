<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSponsorTree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tree_sponsor', function (Blueprint $table)
        {
            $table->increments('tbl_sponsor_tree');
            $table->integer('sponsor_tree_parent_id')->unsigned();
            $table->integer('sponsor_tree_child_id')->unsigned();
            $table->integer('sponsor_tree_level');
            $table->foreign('sponsor_tree_parent_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
            $table->foreign('sponsor_tree_child_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("tbl_tree_sponsor");
    }
}
