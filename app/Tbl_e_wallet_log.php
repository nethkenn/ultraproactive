<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Tbl_e_wallet_log extends Model 
{





	protected $table = 'tbl_e_wallet_log';
	protected $primaryKey = 'stockist_id';
	protected $fillable = [
							'e_wallet_details',
							'e_wallet_update',
							'e_wallet_log_key',
	 						];



	

}