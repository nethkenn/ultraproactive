<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Tbl_agentRefNo extends Model 
{





	protected $table = 'tbl_agentRefNo';
	protected $primaryKey = 'agentRefNo';
	protected $fillable = [
							'transaction_code',
							'responseCode',
							'remarks',
							'data',
	 						];

}