<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOppurtunityV9787 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_opportunity', function (Blueprint $table) {
            $table->increments('opportunity_id');
            $table->string('opportunity_title');
            $table->text('opportunity_content');
            $table->text('opportunity_link');
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
        Schema::drop('tbl_oppurtunity');
    }
}
