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
use Session;
use App\Tbl_order_stocks;
use App\Rel_order_stocks;
use App\Rel_order_stocks_package;	

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
        $data['_order'] = Tbl_order_stocks::where('status',$status)->join('tbl_stockist_user','tbl_stockist_user.stockist_user_id','=','tbl_order_stocks.stockist_user_id')
                                                                    ->get();
 	 	     
        return view('admin.maintenance.stockist_order', $data);
	}
	public function request()
	{
		$id = Request::input('id');
        $data['product'] = Rel_order_stocks::where('order_stocks_id',$id)->join('tbl_product','tbl_product.product_id','=','rel_order_stocks.product_id')->select('product_name','quantity','tbl_product.product_id')->get();
        $data['package'] = Rel_order_stocks_package::where('order_stocks_id',$id)->join('tbl_product_package','tbl_product_package.product_package_id','=','rel_order_stocks_package.product_package_id')->select('product_package_name','quantity','tbl_product_package.product_package_id')->get();
       	$data['error'] = null;		
        if(isset($_POST['_token']))
        {	

        	$ctr = 0;
        	$check = Tbl_order_stocks::where('order_stocks_id',$id)->first();
        	if($check->status == "Pending")
        	{
        		$product = Rel_order_stocks::where('order_stocks_id',$id)->get();
        		foreach($product as $key => $prod)
        		{
        			$company = Tbl_product::where('product_id',$prod->product_id)->first()->stock_qty;
        			$stock = Tbl_stockist_inventory::where('product_id',$prod->product_id)->where('stockist_id',$check->stockist_id)->first()->stockist_quantity;

        			$updatestock['stockist_quantity'] = $stock + $prod->quantity;
        			$updatecompany['stock_qty'] = $company - $prod->quantity;
        			if($updatecompany['stock_qty'] >= 0)
        			{
	        				Tbl_product::where('product_id',$prod->product_id)->update($updatecompany);
							Tbl_stockist_inventory::where('product_id',$prod->product_id)->where('stockist_id',$check->stockist_id)->update($updatestock);
        			}

        		}


        		$condition = false;

        		$packages = Rel_order_stocks_package::where('order_stocks_id',$id)->get();

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
						else
						{
							foreach($product as $key => $prod)
							{	
								$new['stock_qty'] = $container[$key];
								Tbl_product::where('product_id',$prod->product_id)->update($new);
							}
								$package = Tbl_stockist_package_inventory::where('stockist_id',$check->stockist_id)->where('product_package_id',$packs->product_package_id)->first();
								$update['package_quantity'] = $package->package_quantity + $value;

								Tbl_stockist_package_inventory::where('stockist_id',$check->stockist_id)->where('product_package_id',$packs->product_package_id)->update($update);
						}					
				}




        		Tbl_order_stocks::where('order_stocks_id',$id)->update(['status'=>"Confirmed"]);
        		return Redirect::to('admin/stockist_request');
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