<?php namespace App\Http\Controllers;

use Request;
use Session;
use App\Tbl_product;
use App\Tbl_product_code;
use App\Tbl_voucher_has_product;
use App\Tbl_account;
use App\Tbl_slot;
use App\Tbl_voucher;
use App\Classes\Globals;
use App\Classes\Admin;
use App\Classes\Log;
use Validator;
use Crypt;
use Datatables;
use Carbon\Carbon;
use DB;




use App\Http\Requests;
use App\Http\Controllers\Controller;
class AdminSalesController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.sale');
	}


	public function process_sale()
	{
		$data['_member_account'] = Tbl_account::all();
        return view('admin.transaction.sale_process', $data);
	}


	public function add_to_cart()
	{

		$cart = Session::get('admin_cart');
		$product = Tbl_product::find(Request::input('product_id'));
		$qty = (Integer)Request::input('qty') == 0 ? 1 : Request::input('qty');

		if($cart)
		{

			if($this->check_in_array(Request::input('product_id'),$cart))
			{
				$cart[Request::input('product_id')]['qty'] =  $cart[Request::input('product_id')]['qty'] + $qty;
				$cart[Request::input('product_id')]['sub_total'] =  $cart[Request::input('product_id')]['qty'] * $product->price;
			}
			else
			{
				$cart = $this->insert_to_session($cart, Request::input(), $product);
			}

		}
		else
		{
			$cart  = $this->insert_to_session($cart, Request::input(), $product);
		}

		Session::put('admin_cart', $cart);
		return json_encode(Session::get('admin_cart'));
	}



	public function edit_cart()
	{
		$cart = Session::get('admin_cart');
		$product = Tbl_product::find(Request::input('product_id'));
		$cart = $this->insert_to_session($cart,Request::input(), $product);
		Session::put('admin_cart', $cart);
		return json_encode(Session::get('admin_cart'));
	}

	public function insert_to_session($cart,$input, $product)
	{


		$qty = (Integer) $input['qty'] == 0 ? 1 : $input['qty'];

		$cart[$input['product_id']]['product_id'] = $product->product_id;
		$cart[$input['product_id']]['sku'] = $product->sku;
		$cart[$input['product_id']]['product_name'] = $product->product_name;
		$cart[$input['product_id']]['qty'] = $qty;
		$cart[$input['product_id']]['price'] = $product->price;
		$cart[$input['product_id']]['sub_total'] = $qty  * (Double)$product->price;

		return $cart;
	}

	public function get_cart()
	{

		$data['cart'] = Session::get('admin_cart');
		$slot_id = Request::input('slot_id');
        $slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                        ->find($slot_id);
        $discount = 0;
        if($slot)
       	{
       		$discount = $slot->discount;
       	}                                               




        $data['discount'] = $discount;
       	$cart_total = $data['cart_total'] = $this->get_cart_total($data['cart']);
       	$discount_pts = $data['discount_pts'] = (($discount / 100) * $cart_total );
       	$final_total = $data['final_total'] = $cart_total - $discount_pts;
        




		
		return view('admin.transaction.sale_cart', $data);
	}


	public function check_in_array($needle, $haystack)
	{	
		foreach ( (array)$haystack as $key => $value)
		{
			if($key==$needle)
			{
				return true;
			}
		}
		return false;
	}

	public function remove_to_cart()
	{
		
		$cart = Session::get('admin_cart');
		unset($cart[Request::input('product_id')]);
		Session::put('admin_cart',$cart);
		return $cart;
	}

	public function process_nonMember()
	{
		// return Request::input();



		$_cart_product = Session::get('admin_cart');


	   

		$request['member_type'] = Request::input('member_type');
		$rules['member_type'] = 'required|check_member_type';

		$request['account_password'] = Request::input('account_password');
		$rules['account_password'] = 'required|validatepass';


		$request['product_count'] = count($_cart_product);
		$rules['product_count'] = 'integer|min:1';

		$message["account_password.validatepass"] = "Incorrect password.";
		$message["member_type.check_member_type"] = "Invalid Customer type.";

		

		if($_cart_product)
	    {

	    	/**
		    * VALIDATOR REQUEST PRODUCT VOUCHER
		    */
	        foreach($_cart_product as $key => $val)
	        {
	            $request['product_'.$key] = $val['product_id'];
	        }

	      	foreach($_cart_product as $key => $val)
	        {

	        	$prod = Tbl_product::find($val['product_id']);
	            $rules['product_'.$key] = 'exists:tbl_product,product_id|check_stock_qty:'.$val['qty'].','.$prod->stock_qty.','.Request::input('status');
	        }

	       	foreach($_cart_product as $key => $val)
	        {

	            $message['product_'.$key.'.check_stock_qty'] = 'The :attribute has unsufficient stock.';
	        }

	    }

	     $this->custom_validate();

		$validator = Validator::make($request, $rules,$message);

        if ($validator->fails())
        {
        	return redirect('admin/transaction/sales/process/')
                        ->withErrors($validator)
                        ->withInput(Request::input());

        }





        $_cart = $_cart_product;
        $cart_total = $this->get_cart_total($_cart);


        // $insert_voucher['slot_id'] = Request::input('slot_id');
        // $insert_voucher['account_id'] = Request::input('account_id');
        $v_code_query = Tbl_voucher::where('voucher_code', Globals::code_generator())->first();  
        $insert_voucher['voucher_code'] = Globals::check_code($v_code_query);
        $insert_voucher['status'] = Request::input('status');

        // $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
        //                                                 ->where('slot_owner', Request::input('account_id'))
        //                                                 ->first();

        $_slot_discount = 0;
        $insert_voucher['discount'] = $_slot_discount;
        $insert_voucher['total_amount'] = $cart_total - (($_slot_discount / 100) * $cart_total);
        /**
         * PAYMENT MODE IS ALWAYS CASH IN PROCESS SALES
         */
        $insert_voucher['payment_mode'] = 1;
        

        $insert_voucher['or_number'] = Request::input('or_number');
    	$insert_voucher['processed_by'] = Admin::info()->admin_id; 
    	$insert_voucher['processed_by_name'] = Admin::info()->account_username ." ( " .Admin::info()->admin_position_name. " )";
        /**
         * CLEAR CART
         */
        Session::forget('admin_cart');
        /**
         * SAVE VOUCHER
         */
        $voucher = new Tbl_voucher($insert_voucher);
        $voucher->save();

         /**
         * SAVE VOUCHER PRODUCT
         */
        $this->add_product_to_voucher_list($voucher->voucher_id,$_cart,Request::input('member_type'), Request::input('status'));

        $admin_log = "Sold Product Voucher # ".$voucher->voucher_id. " to a non-member as ".  Admin::info()->admin_position_name.".";
        Log::account(Admin::info()->account_id, $admin_log);


        $success_message = "Voucher # " .$voucher->voucher_id. " was successfully process."; 
        return redirect('admin/transaction/sales/')->with('success_message', $success_message);



	}


	public function process_member()
	{	
		/**
		 * GET PRODUCT CART
		 */
		$_cart_product = Session::get('admin_cart');

		// dd(count($_cart_product));

		

		$request['member_type'] = Request::input('member_type');
		$rules['member_type'] = 'required|check_member_type';


		$request['or_number'] = Request::input('or_number');
		$rules['or_number'] = 'unique:tbl_voucher,or_number';

		

		$request['account_id'] = Request::input('account_id');
		$rules['account_id'] = 'required|exists:tbl_account,account_id';

		$request['slot_id'] = Request::input('slot_id');
		$rules['slot_id'] = 'required|exists:tbl_slot,slot_id,slot_owner,'.Request::input('account_id');

		$request['status'] = Request::input('status');
		$rules['status'] = 'required|stat';
		
		$request['account_password'] = Request::input('account_password');
		$rules['account_password'] = 'required|validatepass';


		$request['product_count'] = count($_cart_product);
		$rules['product_count'] = 'integer|min:1';



		
		$message["status.stat"] = "Invalid status value.";
		$message["account_password.validatepass"] = "Incorrect password.";
		$message["member_type.check_member_type"] = "Invalid Customer type.";

		/**
		 * CART PRODCT VALIDATION
		 */
		if($_cart_product)
	    {

	    	/**
		    * VALIDATOR REQUEST PRODUCT VOUCHER
		    */
	        foreach($_cart_product as $key => $val)
	        {
	            $request['product_'.$key] = $val['product_id'];
	        }

	      	foreach($_cart_product as $key => $val)
	        {



	        	$prod = Tbl_product::find($val['product_id']);
	            $rules['product_'.$key] = 'exists:tbl_product,product_id|check_stock_qty:'.$val['qty'].','.$prod->stock_qty.',processed';
	        }

	       	foreach($_cart_product as $key => $val)
	        {

	            $message['product_'.$key.'.check_stock_qty'] = 'The :attribute has unsufficient stock.';
	        }
	    }

		/**
		 * INCLUDE CUSTOM VALIDATION FUNCTION
		 */
		$this->custom_validate();

		$validator = Validator::make($request, $rules, $message);

        if ($validator->fails())
        {
        	return redirect('admin/transaction/sales/process/')
                        ->withErrors($validator)
                        ->withInput(Request::input());

        }


        $_cart = Session::get('admin_cart');
        $cart_total = $this->get_cart_total($_cart);


        $insert_voucher['slot_id'] = Request::input('slot_id');
        $insert_voucher['account_id'] = Request::input('account_id');
        $v_code_query = Tbl_voucher::where('voucher_code', Globals::code_generator())->first();  
        $insert_voucher['voucher_code'] = Globals::check_code($v_code_query);
        $insert_voucher['status'] = Request::input('status');


        $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                        ->where('slot_owner', Request::input('account_id'))
                                                        ->first();
        $insert_voucher['discount'] = $_slot->discount;
        $insert_voucher['total_amount'] = $cart_total - (($_slot->discount / 100) * $cart_total);
        /**
         * PAYMENT MODE IS ALWAYS CASH IN PROCESS SALES
         */
        $insert_voucher['payment_mode'] = 1;
        if(Request::input('status') == 'processed')
        {
        	$insert_voucher['or_number'] = Request::input('or_number');
        	$insert_voucher['processed_by'] = Admin::info()->admin_id; 
        	$insert_voucher['processed_by_name'] = Admin::info()->account_username ." ( " .Admin::info()->admin_position_name. " )";
        }
        

        $voucher = new Tbl_voucher($insert_voucher);
        $voucher->save();
        $this->add_product_to_voucher_list($voucher->voucher_id,$_cart,Request::input('member_type'), Request::input('status'));

    	/**
		 * UPDATE ACCOUNT/ADMIN LOG
		 */
 
        	$buyer = Tbl_account::find(Request::input('account_id'));
        	$admin_log = "Sold Product Voucher # ".$voucher->voucher_id. " to account #".$buyer->account_id." ".$buyer->account_name." (".$buyer->account_username.")as ".  Admin::info()->admin_position_name.".";
        	$buyer_log = "Bought Product Voucher # ".$voucher->voucher_id. " from ".Admin::info()->account_name. " ( " .Admin::info()->admin_position_name." ). "; 
        	Log::account(Request::input('account_id'), $buyer_log);
	       	Log::account(Admin::info()->account_id, $admin_log);




	    /**
         * CLEAR CART
         */
        Session::forget('admin_cart');
        // dd($voucher);
        $success_message = "Voucher # " .$voucher->voucher_id. " was successfully process."; 
        return redirect('admin/transaction/sales/')->with('success_message', $success_message);

       
        




	}

	public function add_product_to_voucher_list($voucher_id, $cart, $member_type, $status='processed')
	{
		foreach ((array)$cart as $key => $value)
		{
			$product = Tbl_product::find($key);


			if($status == 'processed' || $member_type == 1)
	        {
				$updated_stock = $product->stock_qty - $value['qty'];
				Tbl_product::where('product_id',$key)->lockForUpdate()->update(['stock_qty'=> $updated_stock] );
				// dd($status);
	        }


			$insert_vouher_product['voucher_id'] = $voucher_id;
			$insert_vouher_product['product_id'] = $value['product_id'];
			$insert_vouher_product['price'] = $value['price'];
			$insert_vouher_product['qty'] = $value['qty'];
			$insert_vouher_product['sub_total'] = $value['sub_total'];
			$insert_vouher_product['unilevel_pts'] = $product->unilevel_pts;
			$insert_vouher_product['binary_pts'] = $product->binary_pts;

			$new_voucher_product = new tbl_voucher_has_product($insert_vouher_product);
			$new_voucher_product->save();

		    if($member_type == 0)
		    {



	    	     /**
                 * FOREACH ITEM QUANTITY CREATE PRODUCT CODE
                 */
	    	    for ($x = 0 ; $x < $value['qty']; $x++)
	            {
		            /**
			    	 * IF MEMBER CREATE A PRODUCT CODE
			    	 */
				    $p_code_query = Tbl_product_code::where('code_activation', Globals::code_generator())->first();  
			        $insert_product_code['code_activation'] = Globals::check_code($p_code_query);
			        // $insert['log_id']
			        $insert_product_code['voucher_item_id'] = $new_voucher_product->voucher_item_id;


			        $product_code = new Tbl_product_code($insert_product_code);
		        	$product_code->save();
	            } 

	        }



		}
	}	


	public function custom_validate()
	{


		Validator::extend('check_member_type', function($attribute, $value, $parameters) 
        {

        	if($value == '1' || $value == "0")
        	{
        		return true;
        	}    
        });

		Validator::extend('check_stock_qty', function($attribute, $value, $parameters) 
        {
    		$status = $parameters[2];

    		if($status == 'processed')
    		{
    			$stock_qty = $parameters[1];
	            $cart_qty = $parameters[0];

	            $stock_minus_cart_qty = $stock_qty - $cart_qty;
	            if($stock_qty < $cart_qty || $stock_minus_cart_qty < 0)
	            {

	            	/* REMOVE FROM THE CART IF PRODUCT HAS NO STOCK*/ 
	                $cart = Session::get('admin_cart');
	                unset($cart[$value]);
	                Session::forget('admin_cart');
	                Session::put('admin_cart',$cart );
	                return false;
	            }
	            else
	            {
	                return true;
	            }
    		}
    		else
    		{
    			return true;
    		}

            
        });

		Validator::extend('stat', function($attribute, $value, $parameters)
		{
			if($value == 'unclaimed' || $value == 'processed')
			{
				return true;
			}
			else
			{
				return false;
			}
        });


        $admin_pass = Crypt::decrypt(Admin::info()->account_password);
        Validator::extend('validatepass', function($attribute, $value, $parameters) use($admin_pass)
		{
			if($admin_pass == $value)
			{
				return true;
			}
			else
			{
				return false;
			}
		
        });


       	Validator::extend('cartCount', function($attribute, $value, $parameters) use($admin_pass)
		{
			if($value > 0 )
			{
				return true;
			}
			else
			{
				return false;
			}
		
        });


	}



	public function get_slot()
	{

		$account_id = Request::input('account_id');


        $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                                ->where('slot_owner', $account_id)
                                                                ->get();

		return $_slot;
	}

	public function get_cart_total($cart)
	{	
		$total = []; 
		

        foreach ((array) $cart as $key => $value)
        {
        	$total[] = $value['sub_total'];
        }





        return array_sum($total);
	}


	public function get_sales()
	{



		$today =  Carbon::now()->toDateString();
		$filter = Request::input('filter');
		$voucher = Tbl_voucher::leftJoin('tbl_account','tbl_account.account_id','=', 'tbl_voucher.account_id')->where('status', 'processed')
								->where(function($query) use($today, $filter)
								{
									switch ($filter)
									{
										case 'today':
											$query->where(DB::raw('DATE(updated_at)'),'=' , $today);
											break;

										
										default:
											$query->whereNotNull('voucher_id');
											// dd('oop');
											break;
											
									}

								})->get();

		return Datatables::of($voucher)	->editColumn('or_number', '{{$or_number ? $or_number : "-"}}')
										->editColumn('account_id', '{{$account_id ? "Member" : "Non-member"}}')
										->editColumn('account_name', '{{$account_name ? $account_name . " (". $account_username. ")" : "-"}}')
										->addColumn('test','<a style="cursor: pointer;" class="view-voucher" voucher-id="{{$voucher_id}}">View Voucher</a>')
			                            ->make(true);
	}






}