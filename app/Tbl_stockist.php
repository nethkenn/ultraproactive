<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Tbl_stockist extends Model 
{





	protected $table = 'tbl_stockist';
	protected $primaryKey = 'stockist_id';
	protected $fillable = [
							'stockist_full_name',
							'stockist_type',
							'stockist_location',
							'stockist_address',
							'stockist_contact_no',
							'archive',
	 						];




	

}