<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_stockist_package_inventory extends Model
{
	protected $table = 'tbl_stockist_package_inventory';
	public $timestamps = false;

	protected $fillable = [
							'product_package_id',
							'stockist_id',
							'package_quantity',
							'archived'
							];
}