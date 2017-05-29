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
use App\Tbl_transaction;
use App\Tbl_product;
use App\Tbl_product_package;
use App\Tbl_product_package_has;
use App\Classes\Log;
use App\Classes\Admin;
use App\Classes\StockistLog;
use Session;
use App\Tbl_order_stocks;
use App\Rel_order_stocks;
use App\Rel_order_stocks_package;	
use App\Tbl_product_discount_stockist;	
use App\Tbl_package_discount_stockist;	

class AdminStockistRequestController extends AdminController
{
	public function index()
	{

        $status = Request::input('status');
        if($status == "")
        {
            $status = "Pending";
        }
        $data['success'] = Session::get('message');
        $data['stats']   = $status;
        
        
        if($status == "confirmed")
        {
        	$get_zero_trans = Tbl_order_stocks::where("status",$status)->where("confirmed",0)->get();
        	
        	foreach($get_zero_trans as $zero_trans)
        	{
        		$transaction = Tbl_transaction::where("extra","LIKE","%Order Request #".$zero_trans->order_stocks_id." %")->first();
        		if($transaction)
        		{
        			$update["confirmed"] = $transaction->transaction_id;
        			Tbl_order_stocks::where("order_stocks_id",$zero_trans->order_stocks_id)->update($update);
        		}
        	}
        }
        $data['_order']  = Tbl_order_stocks::where('status',$status)->join('tbl_stockist_user','tbl_stockist_user.stockist_user_id','=','tbl_order_stocks.stockist_user_id')
                                                                    ->leftJoin("tbl_transaction","tbl_transaction.transaction_id","=","tbl_order_stocks.confirmed")
                                                                    ->select('*','tbl_order_stocks.created_at as order_created_id')
                                                                    ->get();
		// dd($data);	
 	 	     
        return view('admin.maintenance.stockist_order', $data);
	}
	public function request()
	{
		$id 		       = Request::input('id');
        $_order 	       = Tbl_order_stocks::where('order_stocks_id',$id)->first();
        $order_id          = $id;
        $id 		       = $_order->stockist_id;
        $data["cur_stats"] = $_order->status;
        $data['product']   = Rel_order_stocks::where('order_stocks_id',$order_id)->join('tbl_product','tbl_product.product_id','=','rel_order_stocks.product_id')->select('tbl_product.price','product_name','quantity','tbl_product.product_id')->get();
    	foreach($data['product'] as $key => $product)
    	{
    		$data['product'][$key]->discounted = Tbl_product_discount_stockist::where("stockist_id",$id)->where("product_id",$product->product_id)->first() != null ? Tbl_product_discount_stockist::where("stockist_id",$id)->where("product_id",$product->product_id)->first()->discount : 0;
    	}  

		
        $data['package'] = Rel_order_stocks_package::where('order_stocks_id',$order_id)->join('tbl_product_package','tbl_product_package.product_package_id','=','rel_order_stocks_package.product_package_id')->select('product_package_name','quantity','tbl_product_package.product_package_id')->get();
		
		foreach($data['package'] as $key => $prod)
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
				$price = $price + ($pack->price * $pack->quantity);
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
	    	
			$data['package'][$key]->price = $price;
			$data['package'][$key]->discounted = $discount;
		}
		
       	$data['error'] = null;		
        if(isset($_POST['_token']))
        {	

        	$ctr = 0;
        	$check = Tbl_order_stocks::where('order_stocks_id',$order_id)->first();
        	if($check->status == "Pending")
        	{
        		$product = Rel_order_stocks::where('order_stocks_id',$order_id)->get();
        		foreach($product as $key => $prod)
        		{
        			$company = Tbl_product::where('product_id',$prod->product_id)->first()->stock_qty;
        			$first_prod = Tbl_product::where('product_id',$prod->product_id)->first();
        			$stock = Tbl_stockist_inventory::where('product_id',$prod->product_id)->where('stockist_id',$check->stockist_id)->first()->stockist_quantity;

        			$updatestock['stockist_quantity'] = $stock + $prod->quantity;
        			$updatecompany['stock_qty'] = $company - $prod->quantity;
        			if($updatecompany['stock_qty'] < 0)
        			{
						$data['error'][$ctr] = $first_prod->product_name." didn't refill, cannot give quantity that is higher than your stocks.";
						$ctr++;
        			}
        		}


        		$condition = false;

        		$packages = Rel_order_stocks_package::where('order_stocks_id',$order_id)->get();

				foreach($packages as $pack => $packs)
				{
						$product = Tbl_product_package_has::where('product_package_id',$packs->product_package_id)->product()->get();
						$package_name = Tbl_product_package::where('product_package_id',$packs->product_package_id)->first();
						$value = $packs->quantity;
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
				}
					
        		if($data['error'] == null)
        		{
		            $process = "REFILL PRODUCT/PACKAGE STOCK (ORDER REQUEST)";
		            $amount = 0;
		            $discountp = 0;
		            $discounta = 0;
		            $totality = 0;
		            $paid = 0;
		            $claimed = 0;
		            $transaction_by =  Admin::info()->account_name;
		            $transaction_to = "Stockist Id #".$id;
		            $transaction_payment_type = "Restock by Admin (Request Order)";
		            $transaction_by_stockist_id = NULL;
		            $transaction_to_id = $id;
		            $extra = "Order Request #".$order_id." has been accepted by Admin Account #".Admin::info()->account_id;
		            $voucher = NULL;
					$remarks  = Request::input("transaction_remarks");
			        $trans_id = StockistLog::transaction($process,$amount,$discountp,$discounta,$totality,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,null,$extra,$voucher,$transaction_to_id,$remarks);
				
			        $prod_disc_amt = 0;
			        $prod_subtotal_amt = 0;
			        $prod_total_amt = 0;
	        		$product = Rel_order_stocks::where('order_stocks_id',$order_id)->get();
	        		foreach($product as $key2 => $prod)
	        		{
	        			$key      = $prod->product_id;
	        			$value    = $prod->quantity;
	        			$prod_qty = Tbl_product::where('product_id',$prod->product_id)->first();
						$qty = Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$prod->product_id)->first();
						$update_prod['stock_qty'] = $prod_qty->stock_qty - $value;
						$update['stockist_quantity'] = $qty->stockist_quantity + $value;	
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
		                    $transaction_amount = $prod_qty->price;
		                    $transaction_amount_discounted = $prod_qty->price - (($data['discount']/100)*$prod_qty->price);
		                    $log = "Product Stocks";
		                    $transaction_qty  = $value;
		                    $transaction_total = $value * $transaction_amount_discounted;
							$prod_discount_insert = $data['discount'];
							$prod_discount_insert_amount = ($value*(($data['discount']/100)*$prod_qty->price));
	            	        $prod_disc_amt = $prod_disc_amt + ($value*(($data['discount']/100)*$prod_qty->price));
					        $prod_subtotal_amt = $prod_subtotal_amt + $prod_qty->price;
					        $prod_total_amt = $prod_total_amt + $transaction_total;
						
							StockistLog::relative($trans_id,$if_product=1,$if_product_package = 0,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total,$prod_discount_insert,$prod_discount_insert_amount);        					
						}
	        		}
					
					$update = null;
	
	        		$packages = Rel_order_stocks_package::where('order_stocks_id',$order_id)->get();
					foreach($packages as $pack => $packs)
					{
						$package_id = $packs->product_package_id;
						$value      = $packs->quantity;
						$condition  = false;
		
						$price = 0;
						$product = Tbl_product_package_has::where('product_package_id',$package_id)->product()->get();
						$package_name = Tbl_product_package::where('product_package_id',$package_id)->first();
						foreach($product as $key => $prod)
						{
							$container[$key] = $prod->stock_qty;
							$past_Quantity[$key] = $prod->stock_qty;
							$multiplier[$key] = $prod->quantity;
							$price = $price + ($prod->price * $prod->quantity); 
							$divided[$key] = $prod->price * $prod->quantity;
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
	                    $transaction_amount 		   = $price;
	                    $transaction_amount_discounted = $price - (($data['discount']/100)*$price);
	                    
						$log = "Product Package Stocks";
						$transaction_qty  = $value;
						$transaction_total = $value * $transaction_amount_discounted;

						$prod_disc_amt = $prod_disc_amt + ($value*(($data['discount']/100)*$price));
						$prod_subtotal_amt = $prod_subtotal_amt + $price;
						$prod_total_amt = $prod_total_amt + $transaction_total;
						
						$prod_discount_insert = $data['discount'];
						$prod_discount_insert_amount = ($value*(($data['discount']/100)*$price));
						
						StockistLog::relative($trans_id,$if_product=0,$if_product_package = 1,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total,$prod_discount_insert,$prod_discount_insert_amount);     


						$update['package_quantity'] = $package->package_quantity + $value;
						Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$package_id)->update($update);
					}
	
					DB::table('tbl_transaction')->where('transaction_id',$trans_id)->update(['order_form_number'=>Request::input("sales_order"),'transaction_amount'=>$prod_subtotal_amt,'transaction_discount_amount'=>$prod_disc_amt,'transaction_total_amount'=>$prod_total_amt]);
	        		Tbl_order_stocks::where('order_stocks_id',$order_id)->update(['status'=>"Confirmed","confirmed"=>$trans_id]);
	        		return Redirect::to('admin/stockist_request');        			
        		}
        		else
        		{
        			$message["_error"] = $data["error"];
        			return Redirect::to('/admin/stockist_request/user?id='.$id,$message);  	
        		}
        	}
        	else
        	{

        	}
        }


	    return view('admin.maintenance.stockist_order_user', $data);
	}
	public function get()
    {
        $id = Request::input('id');                          
        $data['product'] = Rel_order_stocks::where('order_stocks_id',$id)->join('tbl_product','tbl_product.product_id','=','rel_order_stocks.product_id')->select('product_name','quantity','tbl_product.product_id')->get();
        $data['package'] = Rel_order_stocks_package::where('order_stocks_id',$id)->join('tbl_product_package','tbl_product_package.product_package_id','=','rel_order_stocks_package.product_package_id')->select('product_package_name','quantity','tbl_product_package.product_package_id')->get();

        return json_encode($data);
    }

}