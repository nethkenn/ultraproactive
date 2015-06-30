<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_product_package_has extends Model
{
	protected $table = 'tbl_product_package_has';
	// protected $primaryKey = 'product_package_id';
	public $timestamps = false;
	protected $fillable = ['product_id', 'quantity','product_package_id'];
	
	

	public function scopeProduct($query)
    {
        return $query	->leftJoin('tbl_product','tbl_product.product_id','=','tbl_product_package_has.product_id')
        				->leftJoin('tbl_product_category','tbl_product_category.product_category_id','=','tbl_product.product_category_id');
    }
}
