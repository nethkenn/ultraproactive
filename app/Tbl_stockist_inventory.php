<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_stockist_inventory extends Model
{
	protected $table = 'tbl_stockist_inventory';
	public $timestamps = false;

	protected $fillable = [
							'stockist_id', 
							'product_id',
							'stockist_quantity',
							'archived'
							];

}