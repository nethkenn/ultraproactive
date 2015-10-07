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
use App\Classes\Settings;
use App\Classes\Log;
use Validator;
use Crypt;
use Datatables;
use Carbon\Carbon;
use DB;
use Mail;
use App\Tbl_wallet_logs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_product_discount;
use App\Tbl_transaction;
class AdminSalesController extends AdminController
{
	public function index()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Visits Sales");
        return view('admin.transaction.sale');
	}


	public function process_sale()
	{	
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Visits Process Sales");
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
		$other = 0;
		$credit = 0;
		if(Request::input('other'))
		{
			$other = Request::input('other');
		}
		if(Request::input('credit'))
		{
			$credit = Request::input('credit');
		}
        $slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                        ->find($slot_id);
        $discount = 0;
        if($slot)
       	{
       		$discount = $slot->discount;
       	}     

       	$other = $other + $credit;


       	$get_total = $this->get_cart_total($data['cart'],$slot_id);
       	$data['other'] = $other;
        $data['discount'] = $get_total['discount'];
       	$cart_total = $data['cart_total'] = $get_total['sub_total'];
       	$discount_pts = $data['discount_pts'] = (($discount / 100) * $cart_total );
       	$data['other_pts'] = (($other / 100) * $cart_total );
       	$total_charge = $data['other_pts'];
       	$final_total = $data['final_total'] = $get_total['total'] + $total_charge;
        

		
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
        $get_total = $this->get_cart_total($_cart);
        $cart_total = $get_total['total'];


        // $insert_voucher['slot_id'] = Request::input('slot_id');
        // $insert_voucher['account_id'] = Request::input('account_id');
        $insert_voucher['voucher_code'] = Globals::create_voucher_code();
        $insert_voucher['status'] = Request::input('status');

        // $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
        //                                                 ->where('slot_owner', Request::input('account_id'))
        //                                                 ->first();
        $additional = 0;

       	$insert_voucher['payment_option'] = Request::input('payment_option');
       	if(Request::input('payment_option') == 1)
       	{
       		$name_of_payment = "Credit Card";
       	}
       	elseif(Request::input('payment_option') == 2)
       	{
       		$name_of_payment = "Cheque";
       	}
       	elseif(Request::input('payment_option') == 0)
       	{
       		$name_of_payment = "Cash";
       	}
       	else
       	{
       		die("Please try again...");
       	}
        if(Request::input('other_charge'))
        {
        	$additional = $additional + Request::input('other_charge');
        }

        if(Request::input('payment_option') == 1)
        {
        	$additional = $additional + 3;
        }

        $_slot_discount = 0;
        $insert_voucher['discount'] = $_slot_discount;
        $insert_voucher['total_amount'] = $cart_total + (($additional/100) * $cart_total);
        /**
         * PAYMENT MODE IS ALWAYS CASH IN PROCESS SALES
         */
        $insert_voucher['payment_mode'] = 1;
 
        $insert_voucher['other_charge'] = $additional;
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

        /* INSERT TRANSACTION RECORD */
		$transact['transaction_description'] = "Purchase from Admin Area";
		$transact['transaction_amount'] = 0;
		$transact['transaction_discount_percentage'] = 0;
		$transact['transaction_discount_amount'] = 0;
		$transact['transaction_total_amount'] = $insert_voucher['total_amount'];
		$transact['transaction_paid'] = 1;
		$transact['transaction_claimed'] = 0;
		$transact['archived'] = 0;
		$transact['transaction_by'] = Admin::info()->account_name;
		$transact['transaction_to'] = "Non Member";
		$transact['transaction_payment_type'] = $name_of_payment." - Non-member";
		$transact['transaction_by_stockist_id'] = null;
		$transact['transaction_to_id'] = null;
		$transact['extra'] = "Admin - Process Sales (Additional Charges = ".$additional."%)";
		$transact['voucher_id'] = $voucher->voucher_id;
		$transact['earned_pv'] = 0;
		$transact['created_at'] = Carbon::now();
		$transact['transaction_slot_id'] = null;
		$transaction_id = Log::transaction($transact);

         /**
         * SAVE VOUCHER PRODUCT
         */
        $this->add_product_to_voucher_list($voucher->voucher_id,$_cart,Request::input('member_type'), Request::input('status'),$transaction_id,1);

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

		if(Request::input('payment_option') == 3 && Request::input('slot_id'))
        {

        	$extra = 0;
	        $_cart = Session::get('admin_cart');
	        $cart_total = $this->get_cart_total($_cart,Request::input('slot_id'));

	        if(Request::input('other_charge'))
	        {
	        	$extra = $extra + Request::input('other_charge');
	        }

	        if(Request::input('payment_option') == 1)
	        {
	        	$extra = $extra + 3;
	        }

        	$getslot = Tbl_slot::where('slot_id',Request::input('slot_id'))->membership()->first();
	        $totally = $cart_total - (($getslot->discount / 100) * $cart_total) + (($extra/100) * $cart_total);
	        $slot_wallet = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->sum('wallet_amount');
        	$ewallet = $slot_wallet - $totally;
			$request['ewallet'] = $ewallet;

			if($ewallet < 0)
			{
				$data['error'][0] = "Slot wallet's is not enough to buy this.";
        		return redirect('admin/transaction/sales/process/')
		                        ->withErrors($data['error'][0])
		                        ->withInput(Request::input());


			}
        }



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
        $get_total = $this->get_cart_total($_cart,Request::input('slot_id'));
        $cart_total = $get_total['total'];
        $additional = 0;

        $insert_voucher['slot_id'] = Request::input('slot_id');
        $insert_voucher['account_id'] = Request::input('account_id');
        $insert_voucher['voucher_code'] = Globals::create_voucher_code();
        $insert_voucher['status'] = Request::input('status');
        $insert_voucher['payment_option'] = Request::input('payment_option');
        if(Request::input('other_charge'))
        {
        	$additional = $additional + Request::input('other_charge');
        }

        if(Request::input('payment_option') == 1)
        {
        	$additional = $additional + 3;
        }
        $insert_voucher['other_charge'] = $additional;

        $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                        ->where('slot_owner', Request::input('account_id'))
                                                        ->first();
        $insert_voucher['discount'] = $_slot->discount;
        $insert_voucher['total_amount'] = $cart_total + (($additional/100) * $cart_total);
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

       	if(Request::input('payment_option') == 3 && Request::input('slot_id'))
        {
        	$updateslot['slot_wallet'] = $ewallet;
        	// Tbl_slot::where('slot_id',Request::input('slot_id'))->update($updateslot);
        }


        $voucher = new Tbl_voucher($insert_voucher);
        $voucher->save();
        $get_slot_owner = Tbl_slot::id(Request::input('slot_id'))->account()->first();

        /* Name of Payment */
        if(Request::input('payment_option') == 1)
       	{
       		$name_of_payment = "Credit Card";
       	}
       	elseif(Request::input('payment_option') == 2)
       	{
       		$name_of_payment = "Cheque";
       	}
       	elseif(Request::input('payment_option') == 0)
       	{
       		$name_of_payment = "Cash";
       	}
       	elseif(Request::input('payment_option') == 3)
       	{
       		$name_of_payment = "E-Wallet";
       	}
       	else
       	{
       		die("Please try again...");
       	}

        /* INSERT TRANSACTION RECORD */
		$transact['transaction_description'] = "Purchase from Admin Area";
		$transact['transaction_amount'] = 0;
		$transact['transaction_discount_percentage'] = 0;
		$transact['transaction_discount_amount'] = 0;
		$transact['transaction_total_amount'] = $insert_voucher['total_amount'];
		$transact['transaction_paid'] = 1;
		$transact['transaction_claimed'] = 0;
		$transact['archived'] = 0;
		$transact['transaction_by'] = Admin::info()->account_name;
		$transact['transaction_to'] = $get_slot_owner->account_name;
		$transact['transaction_payment_type'] = $name_of_payment." - Member";
		$transact['transaction_by_stockist_id'] = null;
		$transact['transaction_to_id'] = $get_slot_owner->account_id;
		$transact['extra'] = "Admin - Process Sales (Additional Charges = ".$additional."%)";
		$transact['voucher_id'] = $voucher->voucher_id;
		$transact['earned_pv'] = 0;
		$transact['created_at'] = Carbon::now();
		$transact['transaction_slot_id'] = Request::input('slot_id');
		$transaction_id = Log::transaction($transact);


        $this->add_product_to_voucher_list($voucher->voucher_id,$_cart,Request::input('member_type'), Request::input('status'),$transaction_id);

    	/**
		 * UPDATE ACCOUNT/ADMIN LOG
		 */
 
    	$buyer = Tbl_account::find(Request::input('account_id'));
    	$admin_log = "Sold Product Voucher # ".$voucher->voucher_id. " to account #".$buyer->account_id." ".$buyer->account_name." (".$buyer->account_username.")as ".  Admin::info()->admin_position_name.".";
    	$buyer_log = "Bought Product Voucher # ".$voucher->voucher_id. " from ".Admin::info()->account_name. " ( " .Admin::info()->admin_position_name." ). "; 
    	Log::account(Request::input('account_id'), $buyer_log);
       	Log::account(Admin::info()->account_id, $admin_log);

       	if(Request::input('payment_option') == 3 && Request::input('slot_id'))
        {
			Log::slot(Request::input('slot_id'), $buyer_log, 0 - $totally, "Process Sales",Request::input('slot_id'));
        }


	    /**
         * CLEAR CART
         */
        Session::forget('admin_cart');
        $success_message = "Voucher # " .$voucher->voucher_id. " was successfully process."; 
        return redirect('admin/transaction/sales/')->with('success_message', $success_message);
	}

	public function add_product_to_voucher_list($voucher_id, $cart, $member_type, $status='processed',$transaction_id,$nonmember = 0)
	{
		$voucher = Tbl_voucher::where('voucher_id',$voucher_id)->first();
		$slot = Tbl_slot::id($voucher->slot_id)->first();
		$earned_pv = 0;
		$amount_of_discount_total = 0;
		$without_discount_total = 0;
		foreach ((array)$cart as $key => $value)
		{
			$product = Tbl_product::find($key);
			if($slot)
			{
	                $discount = Tbl_product_discount::where('membership_id',$slot->slot_membership)->where('product_id',$key)->first();
	                if($discount)
	                {
	                    $discount = $discount->discount;
	                }
	                else
	                {
	                    $discount = 0;
	                }	
			}
			else
			{
				$discount = 0;
			}

			if($status == 'processed' || $member_type == 1)
	        {
				$updated_stock = $product->stock_qty - $value['qty'];
				Tbl_product::where('product_id',$key)->lockForUpdate()->update(['stock_qty'=> $updated_stock] );
				// dd($status);
	        }

	        $discount_amount = ($discount/100)*$value['sub_total'];
	        $sub_total = $value['sub_total'] - (($discount/100)*$value['sub_total']);
			$insert_vouher_product['voucher_id'] = $voucher_id;
			$insert_vouher_product['product_id'] = $value['product_id'];
			$insert_vouher_product['price'] = $value['price'];
			$insert_vouher_product['qty'] = $value['qty'];
			$insert_vouher_product['sub_total'] =$sub_total;
			$insert_vouher_product['unilevel_pts'] = $product->unilevel_pts * $value['qty'];
			$insert_vouher_product['binary_pts'] = $product->binary_pts * $value['qty'];
			$insert_vouher_product['product_discount'] = $discount;
			$insert_vouher_product['product_discount_amount'] = $discount_amount;
			$new_voucher_product = new Tbl_voucher_has_product($insert_vouher_product);
			$new_voucher_product->save();


			/* PER PRODUCT TRANSACTION */
			$prod_transact['transaction_id'] = $transaction_id;
			$prod_transact['if_product'] = 1;  
			$prod_transact['if_product_package'] = 0;  
			$prod_transact['if_code_pin'] = 0; 
			$prod_transact['product_id'] = $value['product_id'];  
			$prod_transact['product_package_id'] = null;  
			$prod_transact['code_pin'] = null;    
			$prod_transact['transaction_amount'] = $value['price'];  
			$prod_transact['transaction_qty'] = $value['qty']; 
			$prod_transact['product_discount'] = $discount;
			$prod_transact['product_discount_amount'] =  $discount_amount;
			$prod_transact['transaction_total'] = $sub_total;  
			$prod_transact['rel_transaction_log'] = $product->product_name; 
			$prod_transact['sub_earned_pv'] = $product->unilevel_pts * $value['qty'];  
			Log::transaction_product($prod_transact);

			$earned_pv = $earned_pv + ($product->unilevel_pts * $value['qty']);
			$amount_of_discount_total = $amount_of_discount_total + $discount_amount;
			$without_discount_total = $without_discount_total + ($value['price'] * $value['qty']);
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
				      
			        $insert_product_code['code_activation'] = Globals::create_product_code();
			        // $insert['log_id']
			        $insert_product_code['voucher_item_id'] = $new_voucher_product->voucher_item_id;


			        $product_code = new Tbl_product_code($insert_product_code);
		        	$product_code->save();
	            } 

	        }



		}

		if($nonmember == 1)
		{
			$earned_pv = 0;
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username."create the voucher #".$voucher_id."(Non-Member)");
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username."create the voucher #".$voucher_id."(Member)");
		}
		
		$update_transaction['earned_pv'] = $earned_pv;
		$update_transaction['transaction_discount_amount'] = $amount_of_discount_total;
		$update_transaction['transaction_amount'] = $without_discount_total;
		Tbl_transaction::where('transaction_id',$transaction_id)->update($update_transaction);
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

	public function get_cart_total($cart,$slot_id = null)
	{	
		$total = []; 
		$overall = [0];
		$discount_amount = [0];
		if($slot_id)
		{	
	        foreach ((array) $cart as $key => $value)
	        {

		        	if($slot_id)
		        	{
			        	$slot = Tbl_slot::where('slot_id',$slot_id)->first();
			            $discount = Tbl_product_discount::where('product_id',$key)->where('membership_id',$slot->slot_membership)->first();
			            if($discount)
			            {
			                $discount = $discount->discount;
			            }
			            else
			            {
			                $discount = 0;
			            }        		
		        	}
		        	else
		        	{
		        		$discount = 0;
		        	}        		



	            $sub_total =   $value['sub_total'] - (($discount/100)*$value['sub_total']);
	            $total[]   =   $value['sub_total'];
	            $discount_amount[]   =   ($discount/100)*$value['sub_total'];
	            $overall[] =   $sub_total;

	        	// $total[] = $value['sub_total'];
	        }		
		}
		else
		{
	        foreach ((array) $cart as $key => $value)
	        {

        		$discount = 0;
	            $sub_total =   $value['sub_total'] - (($discount/100)*$value['sub_total']);
	            $total[]   =   $value['sub_total'];
	            $discount_amount[]   =   ($discount/100)*$value['sub_total'];
	            $overall[] =   $sub_total;
	        }			
		}



        $data['total'] = array_sum($overall);
        $data['sub_total'] = array_sum($total);
        $data['discount'] = array_sum($discount_amount);

        return $data;
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
										->addColumn('option','{{$payment_option == 1 ? "Credit" : ""}} {{$payment_option == 0 ? "Cash" : ""}} {{$payment_option == 2 ? "Cheque" : ""}} {{$payment_option == 3 ? "Ewallet" : ""}}')
			                           	->addColumn('test','<a style="cursor: pointer;" class="view-voucher" voucher-id="{{$voucher_id}}">View Voucher</a>') 
			                            ->make(true);
	}



	public function sale_or()
	{


		$voucher_id = Request::input('voucher_id');
		$voucher = Tbl_voucher::leftJoin('tbl_account', 'tbl_account.account_id'  ,'=',  'tbl_voucher.account_id')->where('voucher_id', $voucher_id)->first();
		$voucher->formatted_date_created = $voucher->created_at->toFormattedDateString();


		$total_product = [];
		$discount = [];
		
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." View voucher #". Request::input('voucher_id'));

		$data['voucher'] = 	$voucher;
		$data['_voucher_product']  = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get();
		
		if($data['_voucher_product'])
		{
			foreach ($data['_voucher_product'] as $key => $value)
			{
				$total_product[] =  $value->sub_total + $voucher->product_discount_amount;
				$discount[] = $value->product_discount_amount;
			}
		}
		else
		{
			$total_product = [];
		}

		$data['product_total'] = array_sum($total_product);
		$data['discount_pts'] =	 array_sum($discount);



		if(Request::isMethod('post'))
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Send an email to the owner of voucher #". Request::input('voucher_id'));
			$company_email = Settings::get('company_email');
			$company_name = Settings::get('company_name');
			$sold_to = Tbl_account::find($data['voucher']->account_id);

			$message_info['from']['email'] = $company_email;
			$message_info['from']['name'] = Admin::info()->account_name . ' ('.Admin::info()->admin_position_name.')';
			$message_info['to']['email'] = $sold_to->account_email;
			// $message_info['to']['email'] = "markponce07@gmail.com";
			$message_info['to']['name'] = $sold_to->account_name;
			$message_info['subject'] = $company_name." - Sale OR";
			Mail::send('emails.sale_or_email', $data, function ($message) use($message_info)
			{
			    $message->from($message_info['from']['email'], $message_info['from']['name']);
			    $message->to($message_info['to']['email'],$message_info['to']['name']);
			    $message->subject($message_info['subject']);
			});


			return json_encode($sold_to->account_email);
		}

		return view('admin.transaction.sale_or', $data);
	}






}