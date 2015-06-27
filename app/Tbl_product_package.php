<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_product_package extends Model
{
	protected $table = 'tbl_product_package';
	protected $primaryKey = 'product_package_id';
	public $timestamps = false;
	protected $fillable = ['product_package_name', 'archived'];
	protected $guarded = ['product_package_id'];
	

}
