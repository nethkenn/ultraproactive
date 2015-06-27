<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_product_package_has extends Model
{
	protected $table = 'tbl_product_package_has';
	// protected $primaryKey = 'product_package_id';
	public $timestamps = false;
	protected $fillable = ['product_id', 'quantity','product_package_id'];
	

}
