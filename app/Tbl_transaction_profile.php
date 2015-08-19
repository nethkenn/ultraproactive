<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_transaction_profile extends Model
{
	protected $table = 'tbl_transaction_profile';
	protected $primaryKey = 'id';
	public $timestamps = false ;
	protected $fillable = [
							'profile_name',
							'transaction_code',
							'archived',
							'account'
						];
}
