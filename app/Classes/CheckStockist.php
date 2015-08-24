<?php namespace App\Classes;
use App\Tbl_stockist_inventory;
use App\Tbl_stockist_package_inventory;
use App\Tbl_product_package;
use App\Tbl_product;
use Carbon;

class CheckStockist
{
	public static function checkinventory($stockist_id)
	{
		$stockistinventory = Tbl_stockist_inventory::where('stockist_id',$stockist_id)->lists('product_id');
		$productinventory = Tbl_product::whereNotIn('product_id', $stockistinventory)->where('archived',0)->get();
		$count = Tbl_product::whereNotIn('product_id', $stockistinventory)->where('archived',0)->count();
		if($count <= 0)
		{

		}
		else
		{
			foreach($productinventory as $product)
			{
				$insert['product_id'] = $product->product_id;
				$insert['stockist_id'] = $stockist_id;
				$insert['stockist_quantity'] = 0;
				$insert['archived'] = 0;
				Tbl_stockist_inventory::insert($insert);
			}
		}
	}

	public static function checkpackage($stockist_id)
	{
		$stockistinventory = Tbl_stockist_package_inventory::where('stockist_id',$stockist_id)->lists('product_package_id');
		$productinventory = Tbl_product_package::whereNotIn('product_package_id', $stockistinventory)->where('archived',0)->get();
		$count = Tbl_product_package::whereNotIn('product_package_id', $stockistinventory)->where('archived',0)->count();
		if($count <= 0)
		{

		}
		else
		{
			foreach($productinventory as $product)
			{
				$insert['product_package_id'] = $product->product_package_id;
				$insert['stockist_id'] = $stockist_id;
				$insert['package_quantity'] = 0;
				$insert['archived'] = 0;
				Tbl_stockist_package_inventory::insert($insert);
			}
		}
	}
}