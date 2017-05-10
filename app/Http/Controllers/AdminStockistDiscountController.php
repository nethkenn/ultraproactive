<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_stockist;
use App\Tbl_product;
use App\Tbl_product_package;
use App\Tbl_product_package_has;
use App\Tbl_product_discount_stockist;
use App\Tbl_package_discount_stockist;
use App\Tbl_stockist_user;
use App\Tbl_stockist_inventory;
use App\Tbl_stockist_package_inventory;
use Datatables;
use App\Tbl_stockist_type;
use Crypt;
use Validator;
use App\Classes\Log;
use App\Classes\Admin;
use DB;
class AdminStockistDiscountController extends AdminController
{
    public function index()
    {

    
        return view('admin.maintenance.stockist_discount');
    }
    
    public function set($id)
    {

		$data['product_discount'] = Tbl_product_discount_stockist::where('stockist_id',$id)->product()->get();
		$data['_product'] = Tbl_product::where('archived',0)->get();
		$data['stockist'] = Tbl_stockist::where('stockist_id',$id)->first();
		
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." view Set product membership discount id #".$id);
		if(isset($_POST['product']))
		{
			$this->put_product_discounted(Request::input(),$id);
			$data['product_discount'] = Tbl_product_discount_stockist::where('stockist_id',$id)->product()->get();
			$data['_product'] = Tbl_product::where('archived',0)->get();
			$data['stockist'] = Tbl_stockist::where('stockist_id',$id)->first();
		}
        return view('admin.maintenance.stockist_discount_set',$data);
    }
    
	public function put_product_discounted($data,$id)
	{	
		$old = DB::table('tbl_product_discount_stockist')->where('stockist_id',$id)->get();

		Tbl_product_discount_stockist::where('stockist_id',$id)->delete();
		foreach($data['product'] as $key => $p)
		{
			$insert['product_id'] = $key;
			$insert['discount'] = $p['quantity'];
			$insert['stockist_id'] = $id;
			Tbl_product_discount_stockist::insert($insert);
		}

		$new = DB::table('tbl_product_discount_stockist')->where('stockist_id',$id)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." change the Set of product discount id stockist #".$id,serialize($old),serialize($new));
	}
	
    public function package_index()
    {

        return view('admin.maintenance.stockist_package_discount');
    }
    
    public function package_set($id)
    {

		$data['package_discount'] = Tbl_package_discount_stockist::where('stockist_id',$id)->product()->get();
		$data['_package']		  = Tbl_product_package::where('archived',0)->get();
		$data['stockist']		  = Tbl_stockist::where('stockist_id',$id)->first();
		$data['requested_id']	  = $id;
		
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." view Set Package discount id #".$id);

		if(isset($_POST['stockist_id']))
		{
			$this->put_package_discounted(Request::input(),$id);
			$data['package_discount'] = Tbl_package_discount_stockist::where('stockist_id',$id)->product()->get();
			$data['_package']		  = Tbl_product_package::where('archived',0)->get();
			$data['stockist']		  = Tbl_stockist::where('stockist_id',$id)->first();
		}
		
		
		foreach($data['package_discount'] as $key => $prod)
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

			$data['package_discount'][$key]->estimated = $estimated;
			$data['package_discount'][$key]->price = $price;
		}
		
		
		foreach($data['_package'] as $key => $prod)
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

			$data["_package"][$key]->estimated = $estimated;
			$data["_package"][$key]->price = $price;
		}
		
        return view('admin.maintenance.stockist_package_discount_set',$data);
    }
    
	public function put_package_discounted($data,$id)
	{	
		$old = DB::table('tbl_package_discount_stockist')->where('stockist_id',$id)->get();
		
		Tbl_package_discount_stockist::where('stockist_id',$id)->delete();

		if(isset($data['product']))
		{
			foreach($data['product'] as $key => $p)
			{
				$insert['product_package_id'] = $key;
				$insert['discount'] = $p['quantity'];
				$insert['stockist_id'] = $id;
				Tbl_package_discount_stockist::insert($insert);
			}
		}

		$new = DB::table('tbl_package_discount_stockist')->where('stockist_id',$id)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." change the Set of product discount id stockist #".$id,serialize($old),serialize($new));
	}
}