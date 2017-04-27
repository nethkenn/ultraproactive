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
use App\Classes\StockistLog;
use App\Tbl_product_discount_stockist;
use App\Tbl_package_discount_stockist;


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

		$data['discount'] = 0;

		if(isset($_POST['quantity']))
		{
			$ctr = 0;


            $process = "REFILL PRODUCT STOCK";
            $amount = 0;
            $discountp = $data['discount'];
            $discounta = 0;
            $totality = 0;
            $paid = 0;
            $claimed = 0;
            $transaction_by =  Admin::info()->account_name;
            $transaction_to = "Stockist Id #".$id;
            $transaction_payment_type = "Restock by Admin";
            $transaction_by_stockist_id = NULL;
            $transaction_to_id = $id;
            $extra = "Restock by Admin Account #".Admin::info()->account_id;
            $voucher = NULL;
			$remarks  = Request::input("transaction_remarks");
	        $trans_id = StockistLog::transaction($process,$amount,$discountp,$discounta,$totality,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,null,$extra,$voucher,$transaction_to_id,$remarks);


	        $prod_disc_amt = 0;
	        $prod_subtotal_amt = 0;
	        $prod_total_amt = 0;
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
				    	$get_disc = Tbl_product_discount_stockist::where("stockist_id",$id)->where("product_id",$key)->first();
				    	if($get_disc)
				    	{
				    		$data['discount'] = $get_disc->discount;
				    	}
				    	else
				    	{
				    		$data['discount'] = 0;
				    	}
				    	
						Log::inventory_log(Admin::info()->admin_id,$key,0 - $value,"Transferred a ".$value." to "." a stockies.",$prod_qty->price - (($data['discount']/100)*$prod_qty->price),1);
						Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->update($update);
						Tbl_product::where('product_id',$key)->update($update_prod);                    

	                    $product_id = $key;
	                    $product_package_id = NULL;
	                    $code_pin = NULL;
	                    $transaction_amount = $prod_qty->price - (($data['discount']/100)*$prod_qty->price);
	                    $log = "Product Stocks";
	                    $transaction_qty  = $value;
	                    $transaction_total = $value * $transaction_amount;
						$prod_discount_insert = $data['discount'];
						$prod_discount_insert_amount = ($value*(($data['discount']/100)*$prod_qty->price));
            	        $prod_disc_amt = $prod_disc_amt + ($value*(($data['discount']/100)*$prod_qty->price));
				        $prod_subtotal_amt = $prod_subtotal_amt + $prod_qty->price;
				        $prod_total_amt = $prod_total_amt + $transaction_total;
					
						StockistLog::relative($trans_id,$if_product=1,$if_product_package = 0,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total,$prod_discount_insert,$prod_discount_insert_amount);        					
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

			DB::table('tbl_transaction')->where('transaction_id',$trans_id)->update(['transaction_amount'=>$prod_subtotal_amt,'transaction_discount_amount'=>$prod_disc_amt,'transaction_total_amount'=>$prod_total_amt]);
			return Redirect::to('/admin/stockist_inventory');
		}



		return view('admin.maintenance.stockist_inventory_refill', $data);
	}

	public function package()
	{
		$id = Request::input('id');
		CheckStockist::checkpackage($id);
		$data["stockist"] = Tbl_stockist::where('tbl_stockist.stockist_id',$id)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')																
																 	     ->first();

		$data['discount'] = 0;
		$data['error'] = null;											
		if(isset($_POST['quantity']))
		{

            $process = "REFILL PRODUCT PACKAGE STOCK";
            $amount = 0;
            $discountp = $data['discount'];
            $discounta = 0;
            $totality = 0;
            $paid = 0;
            $claimed = 0;
            $transaction_by =  Admin::info()->account_name;
            $transaction_to = "Stockist Id #".$id;
            $transaction_payment_type = "Restock by Admin";
            $transaction_by_stockist_id = NULL;
            $transaction_to_id = $id;
            $extra = "Restock Package by Admin Account #".Admin::info()->account_id;
            $voucher = NULL;
			$remarks  = Request::input("transaction_remarks");
	        $trans_id = StockistLog::transaction($process,$amount,$discountp,$discounta,$totality,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,null,$extra,$voucher,$transaction_to_id,$remarks);
	        $prod_disc_amt = 0;
	        $prod_subtotal_amt = 0;
	        $prod_total_amt = 0;

			$ctr = 0;
			foreach($_POST['quantity'] as $package_id => $value)
			{
				$condition = false;

				$price = 0;
				$product = Tbl_product_package_has::where('product_package_id',$package_id)->product()->get();
				$package_name = Tbl_product_package::where('product_package_id',$package_id)->first();
				foreach($product as $key => $prod)
				{
					$container[$key] = $prod->stock_qty;
					$past_Quantity[$key] = $prod->stock_qty;
					$multiplier[$key] = $prod->quantity;
					$price = $price + $prod->price; 
					$divided[$key] = $prod->price;
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
			    	$get_disc = Tbl_package_discount_stockist::where("stockist_id",$id)->where("product_package_id",$package_id)->first();
			    	if($get_disc)
			    	{
			    		$data['discount'] = $get_disc->discount;
			    	}
			    	else
			    	{
			    		$data['discount'] = 0;
			    	}
			    	
					foreach($product as $key => $prod)
					{	
						$new['stock_qty'] = $container[$key];
						Tbl_product::where('product_id',$prod->product_id)->update($new);
						Log::inventory_log(Admin::info()->admin_id,$prod->product_id,0 - $value*$multiplier[$key],"Transferred a ".$value." to "." a stockies (Package #".$package_id.").",$divided[$key] - (($data['discount']/100)*$divided[$key]),1);
					}

						$package = Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$package_id)->first();


						$product_id = NULL;
						$product_package_id = $package_id;
						$code_pin = NULL;
						$transaction_amount = $price - (($data['discount']/100)*$price);
						$log = "Product Package Stocks";
						$transaction_qty  = $value;
						$transaction_total = $value * $transaction_amount;

						$prod_disc_amt = $prod_disc_amt + ($value*(($data['discount']/100)*$price));
						$prod_subtotal_amt = $prod_subtotal_amt + $price;
						$prod_total_amt = $prod_total_amt + $transaction_total;
						
						$prod_discount_insert = $data['discount'];
						$prod_discount_insert_amount = ($value*(($data['discount']/100)*$price));
						
						StockistLog::relative($trans_id,$if_product=0,$if_product_package = 1,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total,$prod_discount_insert,$prod_discount_insert_amount);     


						$update['package_quantity'] = $package->package_quantity + $value;
						Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$package_id)->update($update);
				}

			}

			DB::table('tbl_transaction')->where('transaction_id',$trans_id)->update(['transaction_amount'=>$prod_subtotal_amt,'transaction_discount_amount'=>$prod_disc_amt,'transaction_total_amount'=>$prod_total_amt]);
			return Redirect::to('/admin/stockist_inventory');
		}

		return view('admin.maintenance.stockist_inventory_package', $data);
	}

	public function ajax_get_product()
	{
		$id = Request::input('id');
		$discount = 0;
	    $product = Tbl_stockist_inventory::where('stockist_id',$id)
	                                                ->orderBy('tbl_stockist_inventory.product_id','asc')
	                                                ->where('tbl_stockist_inventory.archived',0)
	                                                ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
	                                                ->get();
	    foreach($product as $key => $prod)
	    {
	    	$get_disc = Tbl_product_discount_stockist::where("stockist_id",$id)->where("product_id",$prod->product_id)->first();
	    	if($get_disc)
	    	{
	    		$discount = $get_disc->discount;
	    	}
	    	else
	    	{
	    		$discount = 0;
	    	}

	        $product[$key]["total"] = $prod->price - (($discount/100)*$prod->price);
	        $product[$key]->discount_container = $discount;
	    }                                           
	    return Datatables::of($product) ->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
	                                    ->addColumn('percent','{{$discount_container}}%')
	                                    ->make(true);     
	}

	public function ajax_get_product_package()
	{
		$id = Request::input('id');
		$discount = 0;
		$product = Tbl_stockist_package_inventory::where('stockist_id',$id)
													->orderBy('tbl_stockist_package_inventory.product_package_id','asc')
													->where('tbl_stockist_package_inventory.archived',0)
													->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_stockist_package_inventory.product_package_id')
													->where('tbl_product_package.archived',0)
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
			$price = 0;
			foreach($package as $keys => $pack)
			{
				$stock[$keys] = $pack->stock_qty;
				$value[$keys] = $pack->quantity;
				$price = $price + $pack->price;
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
			
	    	$get_disc = Tbl_package_discount_stockist::where("stockist_id",$id)->where("product_package_id",$prod->product_package_id)->first();
	    	if($get_disc)
	    	{
	    		$discount = $get_disc->discount;
	    	}
	    	else
	    	{
	    		$discount = 0;
	    	}
	    	
			$product[$key]->estimated = $estimated;
			$product[$key]->price = $price - (($discount/100)*$price);
			$product[$key]->discount_container = $discount;
		}

        return datatables::of($product)	->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_package_id}}">ADD</a>')
        								->addColumn('quantity','{{$package_quantity}}')
        								->addColumn('discount','{{$discount_container}}%')
        								->addColumn('price','{{$price}}')
								        ->make(true);
	}
}