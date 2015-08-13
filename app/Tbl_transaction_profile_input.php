<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_transaction_profile_input extends Model
{
    protected $table = 'tbl_transaction_profile_input';
	public $timestamps = false ;
	protected $fillable = [
							'profile_id',
							'input_id',
							'value'
						];
}
