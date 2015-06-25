<?php namespace App\Classes;
use DB;
use Crypt;
use Session;

class Collection
{
	public static $table = 'tbl_product_collection';
	public static $primary = 'product_id';

	// public static function foin($collection_id)
	// {
	// 	$collection_id = Crypt::encyrpt($collection_id);
	// 	Session::put(Collection::$primary, $collection_id);
	// }

	public static function info()
	{
		
		$collection_id = Collection::id();
		if($product_id)
		{
			$return = DB::table(Collection::$table)->where(Collection::$primary, $product_id)->first();
			return $return;
		}
		else
		{
			return false;
		}
			
	}

}