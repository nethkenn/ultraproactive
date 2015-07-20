<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPlacementTree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tree_placement', function (Blueprint $table)
        {
            $table->increments('placement_tree_id');
            $table->integer('placement_tree_parent_id')->unsigned();
            $table->integer('placement_tree_child_id')->unsigned();
            $table->integer('placement_tree_level');
            $table->string('placement_tree_position')->default('left');
            $table->foreign('placement_tree_parent_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
            $table->foreign('placement_tree_child_id')->references('slot_id')->on('tbl_slot')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("tbl_tree_placement");
    }
}
