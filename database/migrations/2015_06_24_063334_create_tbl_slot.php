<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSlot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_slot', function(Blueprint $table)
        {
            $table->increments('slot_id');
            $table->integer('slot_owner');
            $table->integer('slot_membership');
            $table->string('slot_type', 4)->default('PS');
            $table->integer('slot_rank')->default(0);
            $table->double('slot_wallet')->default(0);
            $table->integer('slot_sponsor');
            $table->integer('slot_placement');
            $table->string('slot_position', 10)->default('left');
            $table->double('slot_binary_left')->default(0);
            $table->double('slot_binary_right')->default(0);
            $table->double('slot_personal_points')->default(0);
            $table->double('slot_group_points')->default(0);
            $table->double('slot_upgrade_points')->default(0);
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
        Schema::drop('tbl_slot');
    }
}
