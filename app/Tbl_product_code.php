<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_product_code extends Model
{
	protected $table = 'tbl_product_code';
	protected $primaryKey = 'product_pin';
	protected $fillable = [

                            'code_activation',
							'voucher_item_id',
							'log_id',
							'used',
							'lock',
							'archived',
	 						];

	


}

