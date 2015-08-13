<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblGetInput2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_get_input'))
        {
            Schema::create('tbl_get_input', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('transaction_code');
                $table->string('inputfield_name');
                $table->tinyInteger('behavior')->default(1)->unsigned();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_get_input');
    }
}
