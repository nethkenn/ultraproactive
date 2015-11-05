<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership_code_sale_has_code extends Model
{
	protected $table = 'tbl_membership_code_sale_has_code';
	protected $fillable = [
							'membershipcode_or_num',
							'code_pin',
							'sold_price',
	 						];
	 						

	public $timestamps = false;
}

