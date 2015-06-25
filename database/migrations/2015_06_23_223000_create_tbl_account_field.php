<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_account_field', function(Blueprint $table)
		{
			$table->increments('account_field_id');
			$table->string('account_field_label');
			$table->string('account_field_type');
			$table->tinyInteger('account_field_required')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_account_field');
	}

}
