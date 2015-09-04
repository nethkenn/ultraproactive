<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Tbl_stockist;
use App\Classes\CheckStockist;
use App\Tbl_stockist_inventory;
use App\Tbl_stockist_package_inventory;
use Datatables;
use App\Tbl_product;
use App\Tbl_product_package;
use App\Tbl_product_package_has;
use App\Classes\Log;
use App\Classes\Admin;



class AdminStockistInventoryController extends AdminController
{
	public function index()
	{
		$data["stockist"] = Tbl_stockist::where('tbl_stockist.archive',0)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')																
																 	     ->get();
												 	     
        return view('admin.maintenance.stockist_inventory', $data);
	}

	public function refill()
	{
		$id = Request::input('id');
		CheckStockist::checkinventory($id);
		$data["stockist"] = Tbl_stockist::where('tbl_stockist.stockist_id',$id)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')																
																 	     ->first();
		$data['inventory'] = Tbl_stockist_inventory::where('stockist_id',$id)
													->orderBy('tbl_stockist_inventory.product_id','asc')
													->where('tbl_stockist_inventory.archived',0)
													->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
													->get();
		$data['error'] = null;											


		if(isset($_POST['quantity']))
		{
			$ctr = 0;
			foreach($_POST['quantity'] as $key => $value)
			{
				$prod_qty = Tbl_product::where('product_id',$key)->first();
				$qty = Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->first();
				$update_prod['stock_qty'] = $prod_qty->stock_qty - $value;
				$update['stockist_quantity'] = $qty->stockist_quantity + $value;	

				if($value >= 0)
				{
					if($update_prod['stock_qty'] >= 0)
					{
						Log::inventory_log(Admin::info()->admin_id,$key,$value,"Transferred a ".$value." to "." a stockies.");
						Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->update($update);
						Tbl_product::where('product_id',$key)->update($update_prod);					
					}
					else
					{
						$data['error'][$ctr] = "Product ".$prod_qty->product_name." didn't refill, cannot give quantity that is higher than your stocks.";
						$ctr++;
					}
				}
				else
				{
					$data['error'][$ctr] = "Product ".$prod_qty->product_name." didn't refill, cannot give quantity that is negative.";
					$ctr++;
				}
			}

		}



		return view('admin.maintenance.stockist_inventory_refill', $data);
	}

	public function package()
	{
		$id = Request::input('id');
		CheckStockist::checkpackage($id);
		$data["stockist"] = Tbl_stockist::where('tbl_stockist.stockist_id',$id)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')																
																 	     ->first();

		$data['error'] = null;											
		if(isset($_POST['quantity']))
		{
			$ctr = 0;
			foreach($_POST['quantity'] as $package_id => $value)
			{
				$condition = false;

				$product = Tbl_product_package_has::where('product_package_id',$package_id)->product()->get();
				$package_name = Tbl_product_package::where('product_package_id',$package_id)->first();
				foreach($product as $key => $prod)
				{
					$container[$key] = $prod->stock_qty;
					$multiplier[$key] = $prod->quantity;
				}

				foreach($container as $key => $cont)
				{
					$container[$key] = $container[$key] - ($value*$multiplier[$key]);
					if($container[$key] >= 0)
					{

					}
					else
					{
						$condition = true;
					}
				}

				if($condition == true)
				{
					$data['error'][$ctr] = $package_name->product_package_name." didn't refill, cannot give quantity that is higher than your stocks.";
					$ctr++;
				}
				else
				{
					foreach($product as $key => $prod)
					{	
						$new['stock_qty'] = $container[$key];
						Tbl_product::where('product_id',$prod->product_id)->update($new);
					}
						$package = Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$package_id)->first();
						$update['package_quantity'] = $package->package_quantity + $value;
						Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$package_id)->update($update);
				}

			}

		}

		return view('admin.maintenance.stockist_inventory_package', $data);
	}

	public function ajax_get_product()
	{
		$id = Request::input('id');

		$product = Tbl_stockist_inventory::where('stockist_id',$id)
													->orderBy('tbl_stockist_inventory.product_id','asc')
													->where('tbl_stockist_inventory.archived',0)
													->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
													->get();
        return Datatables::of($product)	->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
								        ->make(true);
	}

	public function ajax_get_product_package()
	{
		$id = Request::input('id');

		$product = Tbl_stockist_package_inventory::where('stockist_id',$id)
													->orderBy('tbl_stockist_package_inventory.product_package_id','asc')
													->where('tbl_stockist_package_inventory.archived',0)
													->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_stockist_package_inventory.product_package_id')
													->get();
		foreach($product as $key => $prod)
		{
			$package = Tbl_product_package_has::where('product_package_id',$prod->product_package_id)->product()->get();
			$ctr = Tbl_product_package_has::where('product_package_id',$prod->product_package_id)->product()->count();
			$ctr = $ctr - 1;
			$stock = null;
			$value = null;
			$estimated = 0;
			$condition = false;
			foreach($package as $keys => $pack)
			{
				$stock[$keys] = $pack->stock_qty;
				$value[$keys] = $pack->quantity;
			}

			while($condition == false)
			{
				for($val=0;$val<=$ctr;$val++)
				{
					$stock[$val] = $stock[$val] - $value[$val];

					if($stock[$val] >= 0)
					{

					}
					else
					{
						$val = $ctr+1;
						$condition = true;
						break;
					} 
				}

				if($condition == false)
				{
					$estimated++;					
				}
			}

			$product[$key]->estimated = $estimated;
		}

        return datatables::of($product)	->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_package_id}}">ADD</a>')
        								->addColumn('quantity','{{$package_quantity}}')
								        ->make(true);
	}
}