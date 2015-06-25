<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCountry extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_country', function(Blueprint $table)
		{
			$table->increments('country_id');
			$table->string('country_name');
			$table->string('currency');
			$table->double('rate');
			$table->tinyInteger('archived')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_country');
	}
}